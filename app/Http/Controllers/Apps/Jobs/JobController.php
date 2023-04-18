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
        ['title' => 'Bewerben als LKW Fahrer', 'name' => 'Fahrer', 'tags' => ['schnellbewerbung', 'fahrer'], 'route' => 'karriere.funnel.show', 'slug' => 'fahrer', 'pages' => [
            // Hast du bereits Erfahrung als LKW Fahrer? -> Ja, Nein
            ['title' => 'Page 1', 'inputs' => [
                ['id' => 'hasExperience', 'type' => 'multiple', 'name' => 'Erfahrung als LKW Fahrer', 'label' => 'Hast du bereits Erfahrung als LKW Fahrer?', 'required' => true, 'options' => [['label' => 'Nein', 'value' => 'Nein'], ['label' => 'Ja', 'value' => 'Ja'],]]
            ]],
            // Welchen Führerschein hast du? -> keinen, C, CE, C und CE
            ['title' => 'Page 2', 'inputs' => [
                ['id' => 'driversLicense', 'type' => 'multiple', 'name' => 'Führerschein', 'label' => 'Welchen Führerschein hast du?', 'required' => true, 'options' => [['label' => 'keinen', 'value' => 'keinen'], ['label' => 'C', 'value' => 'C'], ['label' => 'CE', 'value' => 'CE'], ['label' => 'C und CE', 'value' => 'C und CE'],], 'exitConditions' => [
                    'keinen' => 'Wir können dir leider keine Stelle anbieten, da du noch keinen LKW-Führerschein besitzt.',
                ]]
            ]],
            // Besitzt du eine gültige Modul 95 Qualifizierung? -> Ja, Nein
            ['title' => 'Page 3', 'inputs' => [
                ['id' => 'hasModul95', 'type' => 'multiple', 'name' => 'Modul 95 Qualifizierung', 'label' => 'Besitzt du eine gültige Modul 95 Qualifizierung?', 'required' => true, 'options' => [['label' => 'Nein', 'value' => 'Nein'], ['label' => 'Ja', 'value' => 'Ja'],]]
            ]],
            // Wie viele Jahre Berufserfahrung kannst du vorweisen? -> keine, 1 bis 5 Jahre, 5 bis 10 Jahre, mehr als 10 Jahre
            ['title' => 'Page 4', 'inputs' => [
                ['id' => 'experienceAsDriver', 'type' => 'multiple', 'name' => 'Erfahrung als LKW Fahrer (Jahre)', 'label' => 'Wie viele Jahre Berufserfahrung kannst du vorweisen?', 'required' => true, 'options' => [['label' => 'keine', 'value' => 'keine'], ['label' => '1 bis 5 Jahre', 'value' => '1 bis 5 Jahre'], ['label' => '5 bis 10 Jahre', 'value' => '5 bis 10 Jahre'], ['label' => 'mehr als 10 Jahre', 'value' => 'mehr als 10 Jahre'],]]
            ]],
            // Wie sind deine Deutschkenntnisse? -> nicht so gut, Okay, Gut, Muttersprache
            ['title' => 'Page 5', 'inputs' => [
                ['id' => 'experienceInLanguage', 'type' => 'multiple', 'name' => 'Deutschkenntnisse', 'label' => 'Wie sind deine Deutschkenntnisse?', 'required' => true, 'options' => [['label' => 'nicht so gut', 'value' => 'nicht so gut'], ['label' => 'Okay', 'value' => 'Okay'], ['label' => 'Gut', 'value' => 'Gut'], ['label' => 'Muttersprache', 'value' => 'Muttersprache'],]]
            ]],
            // Frühestmögliches Eintrittsdatum -> Textfeld (Schnellauswahl: sofort, nächster Monatsbegin, in 4 Wochen, in 3 Monaten, später)
            ['title' => 'Page 6', 'inputs' => [
                ['id' => 'startDate', 'type' => 'text', 'name' => 'Frühstes Einstiegsdatum', 'label' => 'Frühestmögliches Eintrittsdatum', 'required' => true, 'options' => [
                    ['color' => '#FF0D22', 'label' => 'sofort', 'value' => 'sofort'],
                    ['color' => '#C90A1B', 'label' => 'nächster Monatsbeginn', 'value' => 'nächster Monatsbegin'],
                    ['color' => '#960814', 'label' => 'in 4 Wochen', 'value' => 'in 4 Wochen'],
                    ['color' => '#75060F', 'label' => 'in 3 Monaten', 'value' => 'in 3 Monaten'],
                    ['color' => '#52040B', 'label' => 'später', 'value' => 'später'],
                ],]
            ]],
        ]],
        ['title' => 'Industriemechaniker / Schlosser / Technischer Produktspezialist als Servicetechniker', 'name' => 'Schlosser', 'tags' => ['schnellbewerbung', 'schlosser'], 'route' => 'karriere.funnel.show', 'slug' => 'schlosser', 'pages' => [
            // Welche technische Ausbildung hast Du? -> Textfeld
            ['title' => 'Page 1', 'inputs' => [
                ['id' => 'education', 'type' => 'text', 'name' => 'Technische Ausbildung', 'label' => 'Welche technische Ausbildung hast Du?', 'required' => true, 'options' => [
                    ['color' => '#FF0D22', 'label' => 'Schlosser', 'value' => 'Schlosser'],
                    ['color' => '#C90A1B', 'label' => 'Industriemechaniker', 'value' => 'Industriemechaniker'],
                    ['color' => '#960814', 'label' => 'Metallbauer', 'value' => 'Metallbauer'],
                ],]
            ]],
            // Hast Du bereits Erfahrungen im Kundendienst gemacht? -> Ja, Nein
            ['title' => 'Page 2', 'inputs' => [
                ['id' => 'hasExperience', 'type' => 'multiple', 'name' => 'Erfahrung im Kundendienst', 'label' => 'Hast Du bereits Erfahrungen im Kundendienst gemacht?', 'required' => true, 'options' => [['label' => 'Nein', 'value' => 'Nein'], ['label' => 'Ja', 'value' => 'Ja'],]]
            ]],
            // Welchen Führerschein hast Du? (Ausschlusskriterium) -> keinen, B, BE
            ['title' => 'Page 3', 'inputs' => [
                ['id' => 'driversLicense', 'type' => 'multiple', 'name' => 'Führerschein', 'label' => 'Welchen Führerschein hast Du?', 'required' => true, 'options' => [['label' => 'keinen', 'value' => 'keinen'], ['label' => 'B', 'value' => 'B'], ['label' => 'BE', 'value' => 'BE'],], 'exitConditions' => [
                    'keinen' => 'Wir können dir leider keine Stelle anbieten, da du noch keinen PKW-Führerschein besitzt.',
                ]]
            ]],
            // Wie viele Jahre Berufserfahrung bringst Du mit? -> keine, 1 bis 5 Jahre, 5 bis 10 Jahre, mehr als 10 Jahre
            ['title' => 'Page 4', 'inputs' => [
                ['id' => 'experienceInYears', 'type' => 'multiple', 'name' => 'Erfahrung (Jahre)', 'label' => 'Wie viele Jahre Berufserfahrung bringst Du mit?', 'required' => true, 'options' => [['label' => 'keine', 'value' => 'keine'], ['label' => '1 bis 5 Jahre', 'value' => '1 bis 5 Jahre'], ['label' => '5 bis 10 Jahre', 'value' => '5 bis 10 Jahre'], ['label' => 'mehr als 10 Jahre', 'value' => 'mehr als 10 Jahre'],]]
            ]],
            // Frühestmögliches Eintrittsdatum
            ['title' => 'Page 5', 'inputs' => [
                ['id' => 'startDate', 'type' => 'text', 'name' => 'Frühstes Einstiegsdatum', 'label' => 'Frühestmögliches Eintrittsdatum', 'required' => true, 'options' => [
                    ['color' => '#FF0D22', 'label' => 'sofort', 'value' => 'sofort'],
                    ['color' => '#C90A1B', 'label' => 'nächster Monatsbeginn', 'value' => 'nächster Monatsbegin'],
                    ['color' => '#960814', 'label' => 'in 4 Wochen', 'value' => 'in 4 Wochen'],
                    ['color' => '#75060F', 'label' => 'in 3 Monaten', 'value' => 'in 3 Monaten'],
                    ['color' => '#52040B', 'label' => 'später', 'value' => 'später'],
                ],]
            ]],
        ]],
        ['title' => 'Elektromonteur / Elektrotechniker / Elektriker als Servicetechniker', 'name' => 'Elektriker', 'tags' => ['schnellbewerbung', 'elektriker'], 'route' => 'karriere.funnel.show', 'slug' => 'elektriker', 'pages' => [
            // Welche elektrotechnische Ausbildung hast Du? -> Textfeld
            ['title' => 'Page 1', 'inputs' => [
                ['id' => 'education', 'type' => 'text', 'name' => 'Elektrotechnische Ausbildung', 'label' => 'Welche elektrotechnische Ausbildung hast Du?', 'required' => true,]
            ]],
            // Hast Du bereits Erfahrungen im Kundendienst gemacht? -> Ja, Nein
            ['title' => 'Page 2', 'inputs' => [
                ['id' => 'hasExperience', 'type' => 'multiple', 'name' => 'Erfahrung im Kundendienst', 'label' => 'Hast Du bereits Erfahrungen im Kundendienst gemacht?', 'required' => true, 'options' => [['label' => 'Nein', 'value' => 'Nein'], ['label' => 'Ja', 'value' => 'Ja'],]]
            ]],
            // Welchen Führerschein hast Du? (Ausschlusskriterium) -> keinen, B, BE
            ['title' => 'Page 3', 'inputs' => [
                ['id' => 'driversLicense', 'type' => 'multiple', 'name' => 'Führerschein', 'label' => 'Welchen Führerschein hast Du?', 'required' => true, 'options' => [['label' => 'keinen', 'value' => 'keinen'], ['label' => 'B', 'value' => 'B'], ['label' => 'BE', 'value' => 'BE'],], 'exitConditions' => [
                    'keinen' => 'Wir können dir leider keine Stelle anbieten, da du noch keinen PKW-Führerschein besitzt.',
                ]]
            ]],
            // Wie viele Jahre Berufserfahrung bringst Du mit? -> keine, 1 bis 5 Jahre, 5 bis 10 Jahre, mehr als 10 Jahre
            ['title' => 'Page 4', 'inputs' => [
                ['id' => 'experienceInYears', 'type' => 'multiple', 'name' => 'Erfahrung (Jahre)', 'label' => 'Wie viele Jahre Berufserfahrung bringst Du mit?', 'required' => true, 'options' => [['label' => 'keine', 'value' => 'keine'], ['label' => '1 bis 5 Jahre', 'value' => '1 bis 5 Jahre'], ['label' => '5 bis 10 Jahre', 'value' => '5 bis 10 Jahre'], ['label' => 'mehr als 10 Jahre', 'value' => 'mehr als 10 Jahre'],]]
            ]],
            // Frühestmögliches Eintrittsdatum
            ['title' => 'Page 5', 'inputs' => [
                ['id' => 'startDate', 'type' => 'text', 'name' => 'Frühstes Einstiegsdatum', 'label' => 'Frühestmögliches Eintrittsdatum', 'required' => true, 'options' => [
                    ['color' => '#FF0D22', 'label' => 'sofort', 'value' => 'sofort'],
                    ['color' => '#C90A1B', 'label' => 'nächster Monatsbeginn', 'value' => 'nächster Monatsbegin'],
                    ['color' => '#960814', 'label' => 'in 4 Wochen', 'value' => 'in 4 Wochen'],
                    ['color' => '#75060F', 'label' => 'in 3 Monaten', 'value' => 'in 3 Monaten'],
                    ['color' => '#52040B', 'label' => 'später', 'value' => 'später'],
                ],]
            ]],
        ]],
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

        if (!$funnel) abort(404);

        return Inertia::render('Apps/Jobs/Funnel/Show', [
            'funnel' => $funnel,
        ]);
    }

    public function storeFunnel(Request $request, $slug)
    {
        // Get all input definitions
        $funnel = collect(self::funnels)->where('slug', $slug)->first();
        $inputs = collect($funnel['pages'])->pluck('inputs')->flatten(1);

        // Transform the array so the id is the key
        $inputs = $inputs->mapWithKeys(function ($item) {
            return [$item['id'] => $item];
        });

        // Generate the validation rules from the input definitions
        $rules = [
            'name' => 'required|string|max:200',
            'email' => 'nullable|email|max:200',
            'phone' => 'required|string|max:200',
            'birthday' => 'required|string|max:200',
            'zip' => 'required|string|max:20',
        ];

        foreach ($inputs as $input) {
            $rule = $input['required'] ? 'required' : 'nullable';

            if ($input['type'] === 'email') $rule .= '|email|max:255';
            
            if ($input['type'] === 'text') $rule .= '|string|max:255';

            if ($input['type'] === 'multiple') $rule .= '|in:'.collect($input['options'])->pluck('value')->implode(',');

            $rules[$input['id']] = $rule;
        }
        


        // Validate the request
        $validated = $request->validate($rules);
        


        $keyLabelLookup = [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Telefon',
            'birthday' => 'Geburtsdatum',
            'zip' => 'PLZ',
        ];
        
        foreach ($inputs as $input)
        {
            $keyLabelLookup[$input['id']] = $input['name'];
        }

        // Format the details
        // try to find the name of the validated input in the keyLabelLookup (or use the id if not found)
        $values = collect($validated)->mapWithKeys(function ($value, $key) use ($keyLabelLookup) {
            return [$keyLabelLookup[$key] ?? $key => $value];
        })->toArray();



        Mail::to(config('mail.addresses.job_applications'))->send(new NewJobApplication($funnel['name'], $values));

        return back();
    }
}
