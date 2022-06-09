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
        return redirect(RouteServiceProvider::HOME);
    }

    public function indexOverview()
    {
        return Inertia::render('Dashboard/Overview');
    }
}
