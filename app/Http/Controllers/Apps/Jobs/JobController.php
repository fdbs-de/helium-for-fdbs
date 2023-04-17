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
    private const funnels = [
        ['name' => 'Bewerben als LKW Fahrer', 'tags' => ['schnellbewerbung', 'fahrer'], 'route' => 'karriere.funnel.show', 'slug' => 'fahrer', 'pages' => [
            // Hast du bereits Erfahrung als LKW Fahrer? -> Ja, Nein
            ['title' => '', 'inputs' => [
                ['id' => 'has-experience', 'type' => 'multiple', 'name' => 'Hast du bereits Erfahrung als LKW Fahrer?', 'required' => true, 'options' => [['label' => 'Nein', 'value' => 'Nein'], ['label' => 'Ja', 'value' => 'Ja'],]]
            ]],
            // Welchen Führerschein hast du? -> keinen, C, CE, C und CE
            ['title' => '', 'inputs' => [
                ['id' => '', 'type' => 'multiple', 'name' => 'Welchen Führerschein hast du?', 'required' => true, 'options' => [['label' => 'keinen', 'value' => 'keinen'], ['label' => 'C', 'value' => 'C'], ['label' => 'CE', 'value' => 'CE'], ['label' => 'C und CE', 'value' => 'C und CE'],]]
            ]],
            // Besitzt du eine gültige Modul 95 Qualifizierung? -> Ja, Nein
            ['title' => '', 'inputs' => [
                ['id' => '', 'type' => 'multiple', 'name' => 'Besitzt du eine gültige Modul 95 Qualifizierung?', 'required' => true, 'options' => [['label' => 'Nein', 'value' => 'Nein'], ['label' => 'Ja', 'value' => 'Ja'],]]
            ]],
            // Wie viele Jahre Berufserfahrung kannst du vorweisen? -> keine, 1 bis 5 Jahre, 5 bis 10 Jahre, mehr als 10 Jahre
            ['title' => '', 'inputs' => [
                ['id' => '', 'type' => 'multiple', 'name' => 'Wie viele Jahre Berufserfahrung kannst du vorweisen?', 'required' => true, 'options' => [['label' => 'keine', 'value' => 'keine'], ['label' => '1 bis 5 Jahre', 'value' => '1 bis 5 Jahre'], ['label' => '5 bis 10 Jahre', 'value' => '5 bis 10 Jahre'], ['label' => 'mehr als 10 Jahre', 'value' => 'mehr als 10 Jahre'],]]
            ]],
            // Wie sind deine Deutschkenntnisse? -> nicht so gut, Okay, Gut, Muttersprache
            ['title' => '', 'inputs' => [
                ['id' => '', 'type' => 'multiple', 'name' => 'Wie sind deine Deutschkenntnisse?', 'required' => true, 'options' => [['label' => 'nicht so gut', 'value' => 'nicht so gut'], ['label' => 'Okay', 'value' => 'Okay'], ['label' => 'Gut', 'value' => 'Gut'], ['label' => 'Muttersprache', 'value' => 'Muttersprache'],]]
            ]],
            // Frühestmögliches Eintrittsdatum -> Textfeld (Schnellauswahl: sofort, nächster Monatsbegin, in 4 Wochen, in 3 Monaten, später)
            ['title' => '', 'inputs' => [
                ['id' => '', 'type' => 'text', 'name' => 'Frühestmögliches Eintrittsdatum', 'required' => true, 'options' => ['sofort', 'nächster Monatsbegin', 'in 4 Wochen', 'in 3 Monaten', 'später'],]
            ]],
        ]],
        ['name' => 'Schlosser', 'tags' => ['schnellbewerbung', 'schlosser'], 'route' => 'karriere.funnel.show', 'slug' => 'schlosser'],
        ['name' => 'Elektriker', 'tags' => ['schnellbewerbung', 'elektriker'], 'route' => 'karriere.funnel.show', 'slug' => 'elektriker'],
    ];

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
            'funnels' => self::funnels,
        ]);
    }

    public function showFunnel($slug)
    {
        $funnel = collect(self::funnels)->where('slug', $slug)->first();

        return Inertia::render('Apps/Jobs/Funnel/'.$slug, [
            'funnel' => $funnel,
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
            'birthday' => 'required|string|max:200',
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
        $formattedDetails .= 'Geburtsdatum: <b>'.$request->birthday.'</b><br>';
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
