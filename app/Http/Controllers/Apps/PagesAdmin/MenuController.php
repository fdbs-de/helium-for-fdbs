<?php

namespace App\Http\Controllers\Apps\PagesAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Apps/PagesAdmin/Menus/Index', [
            'items' => [],
        ]);
    }
}
