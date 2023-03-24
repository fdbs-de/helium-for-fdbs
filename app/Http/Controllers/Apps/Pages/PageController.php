<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show(Request $request)
    {
        $page = Page::where('status', 'published')->firstWhere('slug', $request->page);

        if (!$page) abort(404);

        $data = [
            'title' => $page->title,
            'content' => $page->resolve(),
        ];

        if ($page->type == 'php')
        {
            return view('apps.pages.render-php', $data);
        }

        if ($page->type == 'builder-php')
        {
            return view('apps.pages.render-builder', $data);
        }

        if ($page->type == 'builder-vue')
        {
            return Inertia::render('Apps/Pages/RenderBuilder', $data);
        }

        abort(404);
    }
}
