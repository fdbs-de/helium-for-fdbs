<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    private function getSettings()
    {
        return Setting::get()->keyBy('key')->map->value;
    }

    public function indexGeneral()
    {
        return Inertia::render('Admin/Settings/General', ['settings' => self::getSettings()]);
    }

    public function indexApps()
    {
        return Inertia::render('Admin/Settings/Apps', ['settings' => self::getSettings()]);
    }

    public function indexMedia()
    {
        return Inertia::render('Admin/Settings/Media', ['settings' => self::getSettings()]);
    }

    public function indexLegal()
    {
        return Inertia::render('Admin/Settings/Legal', ['settings' => self::getSettings()]);
    }



    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site.name' => 'present|nullable|string|max:255',
            'site.slogan' => 'present|nullable|string|max:255',
            'site.domain' => 'present|nullable|string|max:255',
            'site.description' => 'present|nullable|string|max:1000',
            'site.language' => 'required|string|in:en,de',
        ]);

        Setting::updateOrCreate(
            ['key' => 'site.name'],
            ['value' => $request->site['name']]
        );

        Setting::updateOrCreate(
            ['key' => 'site.slogan'],
            ['value' => $request->site['slogan']]
        );

        Setting::updateOrCreate(
            ['key' => 'site.domain'],
            ['value' => $request->site['domain']]
        );

        Setting::updateOrCreate(
            ['key' => 'site.description'],
            ['value' => $request->site['description']]
        );

        Setting::updateOrCreate(
            ['key' => 'site.language'],
            ['value' => $request->site['language']]
        );

        return back();
    }



    public function updateApps(Request $request)
    {
        $request->validate([
            'apps.blog' => 'required|boolean',
            'apps.jobs' => 'required|boolean',
            'apps.intranet' => 'required|boolean',
            'apps.wiki' => 'required|boolean',
        ]);
        
        Setting::updateOrCreate(
            ['key' => 'apps.enabled.blog'],
            ['value' => $request->apps['blog']]
        );

        Setting::updateOrCreate(
            ['key' => 'apps.enabled.jobs'],
            ['value' => $request->apps['jobs']]
        );

        Setting::updateOrCreate(
            ['key' => 'apps.enabled.intranet'],
            ['value' => $request->apps['intranet']]
        );

        Setting::updateOrCreate(
            ['key' => 'apps.enabled.wiki'],
            ['value' => $request->apps['wiki']]
        );

        return back();
    }



    public function updateLegal(Request $request)
    {
        $request->validate([
            'legal.disclaimer' => 'present|nullable|string|max:1000',
        ]);

        Setting::updateOrCreate(
            ['key' => 'legal.disclaimer'],
            ['value' => $request->legal['disclaimer']]
        );

        return back();
    }
}
