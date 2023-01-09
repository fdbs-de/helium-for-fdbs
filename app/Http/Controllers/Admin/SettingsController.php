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
}
