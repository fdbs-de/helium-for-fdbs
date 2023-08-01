<?php

namespace App\Http\Controllers\Apps\Fairs;

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
        return Inertia::render('Apps/Fairs/Messeanmeldung');
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
}
