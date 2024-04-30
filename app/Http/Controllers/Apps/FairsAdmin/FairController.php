<?php

namespace App\Http\Controllers\Apps\FairsAdmin;

use App\Http\Controllers\Controller;
use App\Models\ScopedData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FairController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/FairsAdmin/Index', [
            'scopes' => ScopedData::select('scope')->distinct()->get()->pluck('scope')->toArray(),
            'keys' => ScopedData::select('key')->distinct()->get()->pluck('key')->toArray(),
        ]);
    }



    public function search(Request $request)
    {
        $query = ScopedData::query();
        
        // START: Search
        if ($request->search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('scope', $request->search)
                ->orWhereFuzzy('key', $request->search)
                ->orWhereFuzzy('value', $request->search);
            });
        }
        // END: Search



        // START: Filter
        if ($request->scope)
        {
            $query->whereIn('scope', $request->scope);
        }

        if ($request->key)
        {
            $query->whereIn('key', $request->key);
        }
        // END: Filter



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';
        
        $query->orderBy($field, $order);
        // END: Sort



        // START: Identifiers
        $ids = $query->pluck('scoped_data.id')->toArray();
        // END: Identifiers



        // START: Pagination
        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);
        
        $query->limit($limit)->offset($offset);
        // END: Pagination

        return response()->json([
            'data' => $query->get(),
            'item_ids' => $ids,
            'total' => $total,
        ]);
    }



    public function export()
    {
        $data = ScopedData::where('scope', 'FDBS Hausmesse 2024')->where('key', 'Anmeldung Lieferant')->get();
        
        // Respect umlauts
        $csv = "\xEF\xBB\xBF";

        // Add header
        $csv .= 'Firma;';
        $csv .= 'Ansprechpartner;';
        $csv .= 'Email;';
        $csv .= 'Telefon;';
        $csv .= 'Name (Rechnung);';
        $csv .= 'Adresse (Rechnung);';
        $csv .= 'PLZ (Rechnung);';
        $csv .= 'Ort (Rechnung);';
        $csv .= 'Standbreite (m);';
        $csv .= 'Standtiefe (m);';
        $csv .= 'Strom 220V;';
        $csv .= 'Strom 380V;';
        $csv .= 'Tische;';
        $csv .= 'Stehtische;';
        $csv .= 'Stühle;';
        $csv .= 'Anrede (Bayerischer Abend);';
        $csv .= 'Vorname (Bayerischer Abend);';
        $csv .= 'Nachname (Bayerischer Abend);';
        $csv .= 'DSGVO;';
        $csv .= 'Aufnahmeerlaubnis;';
        $csv .= 'Anmeldedatum';
        $csv .= PHP_EOL;

        foreach ($data as $item)
        {
            for ($i = 0; $i < count($item->value['participants']); $i++)
            {
                $csv .= optional($item->value)['company'] . ';';
                $csv .= optional($item->value)['name'] . ';';
                $csv .= optional($item->value)['email'] . ';';
                $csv .= optional($item->value)['phone'] . ';';
                $csv .= optional($item->value)['billing_name'] . ';';
                $csv .= optional($item->value)['billing_address'] . ';';
                $csv .= optional($item->value)['billing_zip'] . ';';
                $csv .= optional($item->value)['billing_city'] . ';';
                $csv .= optional($item->value)['stand_width'] . ';';
                $csv .= optional($item->value)['stand_depth'] . ';';
                $csv .= (optional($item->value)['options']['power220'] ?? 'nicht benötigt'). ';';
                $csv .= (optional($item->value)['options']['power380'] ?? 'nicht benötigt'). ';';
                $csv .= (optional($item->value)['options']['table'] ?? 'keine'). ';';
                $csv .= (optional($item->value)['options']['standing_table'] ?? 'keine'). ';';
                $csv .= (optional($item->value)['options']['chair'] ?? 'keine'). ';';
                $csv .= optional($item->value)['participants'][$i]['salutation'] . ';';
                $csv .= optional($item->value)['participants'][$i]['firstname'] . ';';
                $csv .= optional($item->value)['participants'][$i]['lastname'] . ';';
                $csv .= optional($item->value)['gdpr'] == true ? 'Ja;' : 'Nein;';
                $csv .= optional($item->value)['video'] == true ? 'Ja;' : 'Nein;';
                $csv .= $item->created_at->format('m.d.Y H:i');
                $csv .= PHP_EOL;
            }
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="anmeldungen.csv"');
    }



    public function delete(Request $request)
    {
        ScopedData::whereIn('id', $request->ids)->delete();

        return back();
    }
}
