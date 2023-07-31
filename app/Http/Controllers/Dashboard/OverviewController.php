<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OverviewController extends Controller
{
    public function redirect()
    {
        return redirect()->route('dashboard.profile');
    }

    public function show()
    {
        return Inertia::render('Apps/Intranet/Overview');
    }
}
