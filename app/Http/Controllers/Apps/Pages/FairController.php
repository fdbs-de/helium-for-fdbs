<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use App\Mail\FormsDefault;
use App\Models\ScopedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class FairController extends Controller
{
    public function show()
    {
        return Inertia::render('Apps/Static/Messeanmeldung');
    }



    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required|string|max:100',
            'company' => 'required|string|max:100',
            'email' => 'required|email',
            'people' => 'required|array|min:1',
            'people.*.salutation' => 'required|in:Herr,Frau,Divers',
            'people.*.firstname' => 'required|string|max:100',
            'people.*.lastname' => 'required|string|max:100',
            'gdpr' => 'required|accepted',
        ]);

        // START: Save to database
        ScopedData::create([
            'scope' => 'fair.adventure-2023',
            'key' => 'signup',
            'value' => [
                'customer' => $request->customer,
                'company' => $request->company,
                'email' => $request->email,
                'people' => $request->people,
                'gdpr' => $request->gdpr,
            ],
        ]);
        // END: Save to database

        // START: Send confirmation email to customer
        $message = 'Vielen Dank für Ihre Anmeldung zur ADVENTure 2023 von FDBS. <br><br>';

        $message .= 'Ihre Daten lauten wie folgt:<br>';
        $message .= 'Kundennummer: ' . $request->customer . '<br>';
        $message .= 'Firma: ' . $request->company . '<br>';
        $message .= 'E-Mail: ' . $request->email . '<br><br>';
        
        $message .= 'Teilnehmer:<br>';
        for ($i = 0; $i < count($request->people); $i++) {
            $message .= '(' . $request->people[$i]['salutation'] . ') ' . $request->people[$i]['firstname'] . ' ' . $request->people[$i]['lastname'];
            $message .= $i === 0 ? ' – Ansprechpartner' : ' – weitere Person';
            $message .= '<br>';
        }

        Mail::send(new FormsDefault('Anmeldungsbestätigung: ADVENTure 2023', $message, [
            'to' => $request->email,
            'replyTo' => ['info@fdbs.de', 'FDBS'],
        ]));
        // END: Send confirmation email to customer

        return back()->with('success', 'Ihre Anmeldung wurde erfolgreich versendet.');
    }



    public function showAdmin()
    {
        return Inertia::render('Admin/Apps/Fairs/Index');
    }



    public function export()
    {
        $data = ScopedData::where('scope', 'fair.adventure-2023')->where('key', 'signup')->get();
        
        // respect umlauts
        $csv = "\xEF\xBB\xBF";
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
                // format date: mm.dd.yyyy hh:mm using carbon
                $csv .= $item->created_at->format('m.d.Y H:i');
                $csv .= PHP_EOL;
            }
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="anmeldungen.csv"');
    }
}
