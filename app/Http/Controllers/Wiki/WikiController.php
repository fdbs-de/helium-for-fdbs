<?php

namespace App\Http\Controllers\Wiki;

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
        return Inertia::render('Apps/Wiki/Overview', [
            'posts' => Post::getPublished('wiki', request()->user()->accessable_role_ids)
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),

            'categories' => PostCategory::getPublished('wiki', request()->user()->accessable_role_ids)
            ->orderBy('name')
            ->get(),
        ]);
    }

    public function show(ViewPostRequest $request)
    {
        $postSlug = $request->postSlug;
        $categorySlug = $request->categorySlug;
        
        $category = ($categorySlug === '-') ? null : PostCategory::where('slug', $categorySlug)->where('scope', 'wiki')->where('status', 'published')->firstOrFail();
        $categoryId = optional($category)->id ?? null;

        $post = Post::getPublishedBySlugAndCategory($postSlug, $categoryId, 'wiki', request()->user()->accessable_role_ids)->firstOrFail();

        return Inertia::render('Apps/Wiki/Show', [
            'post' => $post,
        ]);
    }
}
