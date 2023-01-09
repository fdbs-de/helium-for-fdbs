<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => Setting::get()->keyBy('key')->map->value,
        ]);
    }



    public function update(Request $request)
    {
        $request->validate([
            'apps.blog' => 'required|boolean',
            'apps.jobs' => 'required|boolean',
            'apps.intranet' => 'required|boolean',
            'apps.wiki' => 'required|boolean',
            'site.name' => 'present|nullable|string|max:255',
            'site.slogan' => 'present|nullable|string|max:255',
            'site.domain' => 'present|nullable|string|max:255',
            'site.description' => 'present|nullable|string|max:1000',
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

        return back();
    }
}
