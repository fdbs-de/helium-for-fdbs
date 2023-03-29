<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?? 'general';

        return Inertia::render('Admin/Settings/'. ucfirst($page), [
            'settings' => Setting::get()->keyBy('key')->map->value,
            'page' => $page,
        ]);
    }

    

    public function update(UpdateSettingsRequest $request)
    {
        foreach ($request->validated() as $key => $value)
        {
            Setting::updateOrCreate([
                'key' => preg_replace('/_/', '.', $key),
            ],[
                'value' => $value,
            ]);
        }

        return back();
    }
}
