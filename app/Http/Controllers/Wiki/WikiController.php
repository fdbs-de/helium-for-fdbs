<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WikiController extends Controller
{
    public function overview()
    {
        return Inertia::render('Wiki/Overview', [
            'posts' => Post::getPublished('wiki')
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),

            'categories' => PostCategory::getPublished('wiki', request()->user()->roles()->pluck('id')->toArray())
            ->orderBy('name')
            ->get(),
        ]);
    }

    public function show($categorySlug, $postSlug)
    {
        $category = ($categorySlug === '-') ? null : PostCategory::where('slug', $categorySlug)->where('scope', 'wiki')->where('status', 'published')->firstOrFail();
        $categoryId = optional($category)->id ?? null;

        $post = Post::getPublishedBySlugAndCategory($postSlug, $categoryId, 'wiki')->firstOrFail();

        return Inertia::render('Wiki/Show', [
            'post' => $post,
        ]);
    }
}
