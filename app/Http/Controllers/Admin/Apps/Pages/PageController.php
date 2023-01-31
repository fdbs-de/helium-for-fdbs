<?php

namespace App\Http\Controllers\Admin\Apps\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Apps/Pages/Pages/Index', [
            'items' => [],
        ]);
    }



    public function editor(Request $request)
    {
        return Inertia::render('Admin/Apps/Pages/Pages/Editor', [
            'item' => [],
        ]);
    }
}
