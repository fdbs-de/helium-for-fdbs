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
        return Inertia::render('Apps/FairsAdmin/Index');
    }



    public function export()
    {
        $data = ScopedData::where('scope', 'FDBS Hausmesse 2024')->where('key', 'Anmeldung Lieferant')->get();
        
        // Respect umlauts
        $csv = "\xEF\xBB\xBF";

        // Add header
        $csv .= 'Firma;Ansprechpartner;Email;Telefon;Name (Rechnung); Adresse (Rechnung);PLZ (Rechnung);Ort (Rechnung);Standbreite (m); Standtiefe (m);Strom 220V;Strom 380V;Tische;Stehtische;Stühle;Anrede (Bayerischer Abend);Vorname (Bayerischer Abend);Nachname (Bayerischer Abend);GDPR;Aufnahmeerlaubnis;Anmeldedatum' . PHP_EOL;

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
}
