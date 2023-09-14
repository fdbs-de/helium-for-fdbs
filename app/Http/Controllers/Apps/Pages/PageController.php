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



    private function render($slug)
    {
        $page = Page::where('status', 'published')->where('slug', $slug)->firstOrFail();

        $data = PublicPageResource::make($page)
        ->additional([
            'prefetched_data' => $this->getPrefetchedData([]),
        ])
        ->resolve();

        return Inertia::render('Apps/Pages/Renderer/BlockBuilder', $data);
    }



    public function show(Request $request)
    {
        // Render page if page slug is given
        if($request->page) return $this->render($request->page);
        
        // Get settings for root page
        $type = Setting::getByKey('apps.pages.root.type');
        $link = Setting::getByKey('apps.pages.root.link');
    
        // Render page based on settings
        if ($type === 'static') return $this->render($link);
        if ($type === 'redirect') return redirect($link, 301);
        if ($type === 'route') return Inertia::render($link);
        
        // Return 404 if no settings are set
        return abort(404);
    }



    public function prefetch(Request $request)
    {
        return response()->json($this->getPrefetchedData($request->all()));
    }
}
