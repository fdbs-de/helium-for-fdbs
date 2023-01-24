<?php

namespace App\Http\Controllers\Admin\Apps\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Apps/Pages/Menus/Index', [
            'items' => [],
        ]);
    }
}
