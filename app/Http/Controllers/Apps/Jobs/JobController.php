<?php

namespace App\Http\Controllers\Apps\Jobs;

use App\Http\Controllers\Controller;
use App\Mail\NewJobApplication;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class JobController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Jobs/Index', [
            'posts' => Post::getPublished('jobs', null, ['roles' => 'all'])
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),
        ]);
    }
    
    public function show($postSlug)
    {
        $post = Post::getPublished('jobs', null, ['roles' => 'all', 'slug' => $postSlug])->firstOrFail();

        return Inertia::render('Apps/Jobs/Show', [
            'post' => $post,
        ]);
    }

    public function showFunnelFahrer()
    {
        return Inertia::render('Apps/Jobs/Fahrer.funnel');
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
            'driversLicense' => 'required|string|max:10',
            'hasModul95' => 'required|in:Ja,Nein',
            'experienceInLanguage' => 'required|string|max:30',
            'startDate' => 'required|string|max:100',
        ]);

        // TODO: this is dangerous, xss or html injection is possible

        $formattedDetails = '';
        $formattedDetails .= 'Stelle: <b>LKW Fahrer</b><br>';
        $formattedDetails .= 'Name: <b>'.$request->name.'</b><br>';
        $formattedDetails .= 'Email: <b>'.$request->email.'</b><br>';
        $formattedDetails .= 'Telefon: <b>'.$request->phone.'</b><br>';
        $formattedDetails .= 'Postleitzahl: <b>'.$request->zip.'</b><br><br>';

        $formattedDetails .= 'Erfahrung als LKW Fahrer: <b>'.$request->hasExperience.'</b><br>';
        $formattedDetails .= 'Erfahrung als LKW Fahrer (Jahre): <b>'.$request->experienceAsDriver.'</b><br>';
        $formattedDetails .= 'Führerschein: <b>'.$request->driversLicense.'</b><br>';
        $formattedDetails .= 'Modul 95 Qualifizierung: <b>'.$request->hasModul95.'</b><br>';
        $formattedDetails .= 'Deutschkenntnisse: <b>'.$request->experienceInLanguage.'</b><br><br>';

        $formattedDetails .= 'Frühstes Einstiegsdatum: <b>'.$request->startDate.'</b><br>';

        Mail::to(config('mail.addresses.job_applications'))->send(new NewJobApplication('LKW Fahrer', $formattedDetails));

        return back();
    }
}