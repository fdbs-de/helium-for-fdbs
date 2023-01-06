<?php

namespace App\Http\Controllers;

use App\Mail\NewJobApplication;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class JobController extends Controller
{
    public function index()
    {
        return Inertia::render('Jobs/Index', [
            'posts' => Post::with(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->where('scope', 'jobs')
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereDate('available_from', '<=', now())->orWhere('available_from', null);
            })
            ->where(function ($query) {
                $query->whereDate('available_to', '>=', now())->orWhere('available_to', null);
            })
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),
        ]);
    }
    
    public function show(Post $post)
    {
        return Inertia::render('Jobs/Show', [
            'post' => $post->load(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
            }]),
        ]);
    }

    public function showFunnelFahrer()
    {
        return Inertia::render('Jobs/Fahrer.funnel');
    }

    public function storeFunnelFahrer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'nullable|email|max:200',
            'phone' => 'required|string|max:200',
            'zip' => 'required|string|max:20',
            'hasExperience' => 'required|in:Ja,Nein',
            'experienceAsDriver' => 'required|string|max:30',
            'nightshift' => 'required|in:Ja,Nein',
            'driversLicense' => 'required|string|max:10',
            'hasModul95' => 'required|in:Ja,Nein',
            'experienceInLanguage' => 'required|string|max:30',
            'startDate' => 'required|string|max:100',
            'salary' => 'nullable|string|max:100',
        ]);

        $formattedDetails = '';
        $formattedDetails .= 'Stelle:<br><b>LKW Fahrer</b><br><br>';
        $formattedDetails .= 'Name:<br><b>'.$request->name.'</b><br><br>';
        $formattedDetails .= 'Email:<br><b>'.$request->email.'</b><br><br>';
        $formattedDetails .= 'Telefon:<br><b>'.$request->phone.'</b><br><br>';
        $formattedDetails .= 'Postleitzahl:<br><b>'.$request->zip.'</b><br><br><br>';

        $formattedDetails .= 'Erfahrung als LKW Fahrer:<br><b>'.$request->hasExperience.'</b><br><br>';
        $formattedDetails .= 'Erfahrung als LKW Fahrer (Jahre):<br><b>'.$request->experienceAsDriver.'</b><br><br>';
        $formattedDetails .= 'Kann Nachts Fahren:<br><b>'.$request->nightshift.'</b><br><br>';
        $formattedDetails .= 'Führerschein:<br><b>'.$request->driversLicense.'</b><br><br>';
        $formattedDetails .= 'Modul 95 Qualifizierung:<br><b>'.$request->hasModul95.'</b><br><br>';
        $formattedDetails .= 'Deutschkenntnisse:<br><b>'.$request->experienceInLanguage.'</b><br><br><br>';

        $formattedDetails .= 'Frühstes Einstiegsdatum:<br><b>'.$request->startDate.'</b><br><br>';
        $formattedDetails .= 'Gehaltswunsch (brutto):<br><b>'.($request->salary ?? 'Nicht angegeben').'</b><br><br>';

        Mail::to(config('mail.addresses.job_applications'))->send(new NewJobApplication('LKW Fahrer', $formattedDetails));

        return back();
    }
}
