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
    public function showVisitorForm()
    {
        return Inertia::render('Apps/Fairs/VisitorSignup');
    }

    public function showDistributorForm()
    {
        return Inertia::render('Apps/Fairs/DistributorSignup');
    }



    public function storeVisitor(Request $request)
    {
        $request->validate([
            'customer' => 'required|string|max:100',
            'company' => 'required|string|max:100',
            'email' => 'nullable|email',
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
        if ($request->email)
        {
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
        }
        // END: Send confirmation email to customer

        return back()->with('success', 'Ihre Anmeldung wurde erfolgreich versendet.');
    }



    public function storeDistributor(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:40',
            'billing_name' => 'required|string|max:100',
            'billing_address' => 'required|string|max:100',
            'billing_zip' => 'required|string|max:10',
            'billing_city' => 'required|string|max:100',
            'standWidth' => 'required|numeric|min:2|max:2000',
            'standDepth' => 'required|numeric|min:3|max:3',
            'options.power220' => 'nullable|min:1',
            'options.power380' => 'nullable|min:1',
            'options.table' => 'nullable|min:1',
            'options.standing_table' => 'nullable|min:1',
            'options.chair' => 'nullable|min:1',
            'participants' => 'nullable|array|max:4',
            'participants.*.salutation' => 'required|in:Herr,Frau,---',
            'participants.*.firstname' => 'required|string|max:100',
            'participants.*.lastname' => 'required|string|max:100',
            'gdpr' => 'required|accepted',
            'video' => 'required|accepted',
        ]);


        // Save to database
        ScopedData::create([
            'scope' => 'FDBS Hausmesse 2024',
            'key' => 'Anmeldung Lieferant',
            'value' => [
                'company' => $request->company,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'billing_name' => $request->billing_name,
                'billing_address' => $request->billing_address,
                'billing_zip' => $request->billing_zip,
                'billing_city' => $request->billing_city,
                'stand_width' => $request->standWidth,
                'stand_depth' => $request->standDepth,
                'options' => $request->options,
                'participants' => $request->participants,
                'gdpr' => $request->gdpr,
                'video' => $request->video,
            ],
        ]);


        // Organizer email
        $message = 'Ein neuer Lieferant hat sich zur FDBS Hausmesse 2024 angemeldet.<br>';
        $message .= 'Bitte prüfen Sie die Anmeldung.<br><br>';

        Mail::send(new FormsDefault('Anmeldung: FDBS Hausmesse 2024', $message, [
            'to' => 'messe@fdbs.de',
            'replyTo' => [$request->email, $request->company],
        ]));


        // Customer email
        $message = 'Ihre Anmeldung zur FDBS Hausmesse 2024 ist bei uns eingegangen.<br>';
        $message .= 'Bitte senden Sie uns Ihr Logo zum Zwecke der Präsentation auf Kundenunterlagen und Homepage an messe@fdbs.de.<br>';
        $message .= '<b>Wir bedanken uns für Ihre Teilnahme!</b><br>';

        Mail::send(new FormsDefault('Anmeldungsbestätigung: FDBS Hausmesse 2024', $message, [
            'to' => $request->email,
            'replyTo' => ['messe@fdbs.de', 'FDBS Messe Team'],
        ]));
        

        return back()->with('success', 'Ihre Anmeldung wurde erfolgreich versendet.');
    }
}
