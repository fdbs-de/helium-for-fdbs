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
            'posts' => Post::with(['category' => function ($query) {
                $query->select('id', 'name', 'slug', 'icon', 'color');
            }])
            ->where('scope', 'wiki')
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereDate('available_from', '<=', now())->orWhere('available_from', null);
            })
            ->where(function ($query) {
                $query->whereDate('available_to', '>=', now())->orWhere('available_to', null);
            })
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),

            'categories' => PostCategory::select('id', 'name', 'slug', 'icon', 'color')
            ->where('status', 'published')
            ->orderBy('name')
            ->get(),
        ]);
    }

    public function show($category, Post $post)
    {
        return Inertia::render('Wiki/Show', [
            'post' => $post->load(['category' => function ($query) {
                $query->select('id', 'name', 'slug', 'icon', 'color');
            }]),
        ]);
    }
}
