<?php

namespace App\Http\Controllers\Apps\PagesAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Pages\CreatePageRequest;
use App\Http\Requests\Apps\Pages\DestroyPageRequest;
use App\Http\Requests\Apps\Pages\DuplicatePageRequest;
use App\Http\Requests\Apps\Pages\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Apps/PagesAdmin/Pages/Index');
    }



    public function search(Request $request)
    {
        $query = Page::select('*');
        
        if ($request->search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('title', $request->search)
                ->orWhereFuzzy('slug', $request->search);
            });
        }
        
        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);
        
        $data = $query->orderBy('created_at', 'desc')->limit($limit)->offset($offset)->get();

        return response()->json([
            'data' => $data,
            'total' => $total,
        ]);
    }



    public function editor(Request $request)
    {
        $pages = [];
        
        if ($request->pages) $pages = Page::whereIn('id', $request->pages)->get();

        return Inertia::render('Apps/SharedAdmin/Editor/Index', [
            'items' => $pages,
        ]);
    }



    public function store(CreatePageRequest $request)
    {
        Page::create($request->validated());

        return back();
    }



    public function duplicate(DuplicatePageRequest $request, Page $page)
    {
        $page->duplicate();

        return back();
    }



    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->validated());

        return back();
    }



    public function delete(DestroyPageRequest $request)
    {
        Page::whereIn('id', $request->ids)->delete();

        return back();
    }
}
