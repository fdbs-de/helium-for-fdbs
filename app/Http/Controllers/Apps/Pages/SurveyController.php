<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use App\Mail\NewSurveySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function show()
    {
        return Inertia::render('Umfragen/MkbsFeedback');
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

        Mail::to('mf@fdbs.de')->send(new NewSurveySubmission('MKBS Kundenzufriedenheit', $values));

        return back();
    }
}
