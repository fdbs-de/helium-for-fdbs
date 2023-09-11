<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\Apps\Pages\MenuResource;
use App\Http\Resources\Apps\Pages\PublicPageResource;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    private function getPrefetchedData($data)
    {
        return [
            'menus' => MenuResource::collection(Menu::all()),
        ];
    }



    public function prefetch(Request $request)
    {
        return response()->json($this->getPrefetchedData($request->all()));
    }



    public function show(Request $request)
    {
        $page = Page::where('status', 'published')->where('slug', $request->page)->firstOrFail();

        $data = PublicPageResource::make($page)
        ->additional([
            'prefetched_data' => $this->getPrefetchedData($request->all()),
        ])
        ->resolve();

        return Inertia::render('Apps/Pages/Renderer/BlockBuilder', $data);
    }



    public function root(Request $request)
    {
        return Inertia::render('Apps/Static/Home');
    }
}
