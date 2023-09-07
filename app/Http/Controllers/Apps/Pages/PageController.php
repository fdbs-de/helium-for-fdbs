<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\Apps\Pages\MenuResource;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
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



        if ($page->renderer == 'php')
        {
            return view('apps.pages.render-php', $data);
        }

        if ($page->renderer == 'builder-php')
        {
            return view('apps.pages.render-builder', $data);
        }

        if ($page->renderer == 'block-builder')
        {
            return Inertia::render('Apps/Pages/Renderer/BlockBuilder', $data);
        }

        abort(404);
    }
}
