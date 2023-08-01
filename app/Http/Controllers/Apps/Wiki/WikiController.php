<?php

namespace App\Http\Controllers\Apps\Wiki;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Wiki\ViewPostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WikiController extends Controller
{
    public function overview(ViewPostRequest $request)
    {
        // START: Filter
        $search = [];
        
        if ($request->category && $request->category !== 'all') $search['category'] = $request->category;
        if ($request->search) $search['query'] = $request->search;

        $posts = Post::getPublished('wiki', request()->user(), $search, false);
        // END: Filter



        // START: Sort
        if (!$request->sort || $request->sort == 'all') $posts->orderByDesc('pinned')->orderBy('title');
        
        $posts->orderByDesc('created_at')->orderByDesc('updated_at'); // Fallback sort
        // END: Sort



        // START: Limit
        if ($request->sort == 'recent') $posts->limit(12);
        // END: Limit



        // START: Return
        return Inertia::render('Apps/Wiki/Overview', [
            'posts' => $posts->get(),

            'categories' => PostCategory::getPublished('wiki', request()->user()->accessable_role_ids)
            ->orderBy('name')
            ->get(),
        ]);
        // END: Return
    }

    public function show(ViewPostRequest $request)
    {
        $postSlug = $request->postSlug;
        $categorySlug = $request->categorySlug;
        
        $category = ($categorySlug === '-') ? null : PostCategory::where('slug', $categorySlug)->where('scope', 'wiki')->where('status', 'published')->firstOrFail();
        $categoryId = optional($category)->id ?? null;

        $post = Post::getPublished('wiki', request()->user(), ['slug' => $postSlug, 'category' => $categoryId])->firstOrFail();

        return Inertia::render('Apps/Wiki/Show', [
            'post' => $post,
        ]);
    }
}
