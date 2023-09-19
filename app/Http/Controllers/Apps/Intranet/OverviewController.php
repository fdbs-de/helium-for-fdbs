<?php

namespace App\Http\Controllers\Apps\Intranet;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OverviewController extends Controller
{
    public function redirect()
    {
        return redirect('/dashboard/home');
    }

    public function show()
    {
        return Inertia::render('Apps/Intranet/Overview');
    }
}
