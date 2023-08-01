<?php

namespace App\Http\Controllers\Apps\Static;

use App\Http\Controllers\Controller;
use App\Mail\NewSurveySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function show()
    {
        return Inertia::render('Apps/Static/Umfragen/MkbsFeedback');
    }

    public function store(Request $request)
    {
        $request->validate([
            'increaseHappiness' => 'nullable|string|max:2047',
            'workshops' => 'nullable|string|max:2047',
            'newsletter' => 'nullable|string|max:2047',
            'note' => 'nullable|string|max:2047',
            'name' => 'nullable|string|max:127',
            'email' => 'nullable|string|max:127',
            'sendAnonymously' => 'present|boolean',
        ]);

        
        $values = $request->all();
        
        if ($request->sendAnonymously)
        {
            $values['name'] = 'Anonym';
            $values['email'] = '###';
        }

        // Give keys real names (in german)
        $labeledValues = [];
        $labelDictonary = [
            'generalSentiment' => 'Allgemeine Zufriedenheit',
            'metricPortfolioSentiment' => 'Leistungsmerkmalen: Angebot',
            'metricQualitySentiment' => 'Leistungsmerkmalen: Qualität',
            'metricPriceSentiment' => 'Leistungsmerkmalen: Preis-Leistung',
            'metricDesignSentiment' => 'Leistungsmerkmalen: Design',
            'departmentPrintSentiment' => 'Zufriedenheit im Bereich Print',
            'departmentWebsiteSentiment' => 'Zufriedenheit im Bereich Web',
            'departmentSocialMediaSentiment' => 'Zufriedenheit im Bereich Social Media',
            'softskillsPolitenessSentiment' => 'Leistungsniveau: Freundlichkeit',
            'softskillsConsultationSentiment' => 'Leistungsniveau: Beratung',
            'softskillsProfessionalismSentiment' => 'Leistungsniveau: Professionalität',
            'softskillsProblemSolvingSentiment' => 'Leistungsniveau: Problemlösung',
            'softskillsOverallSentiment' => 'Leistungsniveau: Gesamteindruck',
            'increaseHappiness' => 'Was können wir tun, um Ihre Zufriedenheit zu erhöhen?',
            'wantsWorkshops' => 'Schulungen/Beratung gewünscht',
            'workshops' => 'Zu Schulungen/Beratung',
            'wantsNewsletter' => 'Angebote/Aktionen gewünscht',
            'newsletter' => 'Zu Angebote/Aktionen',
            'serviceSocialMediaAcknowledgement' => 'Leistungen bekannt: Social Media Betreuung',
            'serviceWebsiteAcknowledgement' => 'Leistungen bekannt: Erstellung von Webseiten / Onlineshops',
            'serviceRecruitingAcknowledgement' => 'Leistungen bekannt: Recruiting',
            'serviceDigitalSignageAcknowledgement' => 'Leistungen bekannt: Digital Signage',
            'servicePhotographyAcknowledgement' => 'Leistungen bekannt: Produktfotografie',
            'serviceStationariesAcknowledgement' => 'Leistungen bekannt: Geschäftsausstattung',
            'serviceAdtechAcknowledgement' => 'Leistungen bekannt: Werbetechnik',
            'productSuggestions' => 'Leistungen / Produkte, welche noch fehlen',
            'competitorQualitySentiment' => 'VS Mitbewerber: Qualität',
            'competitorPriceSentiment' => 'VS Mitbewerber: Preis-Leistung',
            'competitorProblemSolvingSentiment' => 'VS Mitbewerber: Problemlösung',
            'competitorOverallSentiment' => 'VS Mitbewerber: Gesamteindruck',
            'wouldRecommend' => 'Wie wahrscheinlich ist es, dass Sie uns als Werbepartner weiterempfehlen',
            'note' => 'Anregungen/Wünsche',
            'name' => 'Name',
            'email' => 'Email',
        ];

        foreach ($values as $key => $value)
        {
            if (array_key_exists($key, $labelDictonary))
            {
                $labeledValues[$labelDictonary[$key] ?? $key] = $value;
            }
        }

        Mail::to('werbung@fdbs.de')->send(new NewSurveySubmission('MKBS Kundenzufriedenheit', $labeledValues));

        return back();
    }
}
