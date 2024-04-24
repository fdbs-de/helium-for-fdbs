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
            'email' => 'required|email',
            'standWidth' => 'required|numeric|min:2|max:2000',
            'standDepth' => 'required|numeric|min:3|max:3',
            'power220' => 'nullable|min:1',
            'power380' => 'nullable|min:1',
            'notes' => 'nullable|string|max:1000',
            'participants' => 'nullable|array|max:4',
            'participants.*.salutation' => 'required|in:Herr,Frau,---',
            'participants.*.firstname' => 'required|string|max:100',
            'participants.*.lastname' => 'required|string|max:100',
            'gdpr' => 'required|accepted',
        ]);

        // START: Emails
        if ($request->email)
        {
            // Organizer email
            $message = 'Ein Lieferant hat sich zur Hausmesse 2024 angemeldet.<br><br>';
    
            $message .= 'Firma: <b>' . $request->company . '</b><br>';
            $message .= 'E-Mail: <b>' . $request->email . '</b><br><br>';

            $message .= 'Standbreite: <b>' . $request->standWidth . 'm</b><br>';
            $message .= 'Standtiefe: <b>' . $request->standDepth . 'm</b><br>';
            $message .= 'Standfläche: <b>' . ($request->standWidth * $request->standDepth) . 'm²</b><br>';
            $message .= '220V Stromanschluss: <b>' . ($request->power220 ? $request->power220.'kW' : 'nicht benötigt') . '</b><br>';
            $message .= '380V Stromanschluss: <b>' . ($request->power380 ? $request->power380.'kW' : 'nicht benötigt') . '</b><br>';
            $message .= 'Sonderwünsche: <b>' . ($request->notes ? $request->notes : 'keine') . '</b><br><br>';
            
            $message .= 'Teilnahme am Oktoberfest: <b>' . (count($request->participants) ? 'ja' : 'nein') . '</b><br>';
            for ($i = 0; $i < count($request->participants); $i++)
            {
                $message .= '• ' . $request->participants[$i]['salutation'] . ' ' . $request->participants[$i]['firstname'] . ' ' . $request->participants[$i]['lastname'];
                $message .= '<br>';
            }
    
            Mail::send(new FormsDefault('Lieferantenanmeldung: Hausmesse 2024', $message, [
                'to' => 'mf@fdbs.de',
                'replyTo' => [$request->email, $request->company],
            ]));



            // Customer email
            $message = 'Ihre Anmeldung zur FDBS Hausmesse 2024 ist bei uns eingegangen.<br>';
            $message .= '<b>Wir bedanken uns für Ihre Teilnahme!</b><br>';

            Mail::send(new FormsDefault('Anmeldungsbestätigung: FDBS Hausmesse 2024', $message, [
                'to' => $request->email,
                'replyTo' => ['messe@fdbs.de', 'FDBS Messe Team'],
            ]));
        }
        // END: Emails

        return back()->with('success', 'Ihre Anmeldung wurde erfolgreich versendet.');
    }
}
