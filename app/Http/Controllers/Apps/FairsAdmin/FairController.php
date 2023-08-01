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
        $data = ScopedData::where('scope', 'fair.adventure-2023')->where('key', 'signup')->get();
        
        // Respect umlauts
        $csv = "\xEF\xBB\xBF";

        // Add header
        $csv .= 'Kundennummer;Firma;Email;Anrede;Vorname;Nachname;Ist Ansprechpartner;GDPR;Datum' . PHP_EOL;

        foreach ($data as $item)
        {
            for ($i = 0; $i < count($item->value['people']); $i++)
            {
                $csv .= $item->value['customer'] . ';';
                $csv .= $item->value['company'] . ';';
                $csv .= $item->value['email'] . ';';
                $csv .= $item->value['people'][$i]['salutation'] . ';';
                $csv .= $item->value['people'][$i]['firstname'] . ';';
                $csv .= $item->value['people'][$i]['lastname'] . ';';
                $csv .= $i === 0 ? 'Ja;' : 'Nein;';
                $csv .= $item->value['gdpr'] === '1' ? 'Ja;' : 'Nein;';
                $csv .= $item->created_at->format('m.d.Y H:i');
                $csv .= PHP_EOL;
            }
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="anmeldungen.csv"');
    }
}
