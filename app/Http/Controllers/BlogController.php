<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Blog/Index', [
            'posts' => Post::with(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->where('scope', 'blog')
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
        ]);
    }

    public function show($category, $post)
    {
        $category = ($category === '-') ? null : PostCategory::where('slug', $category)->where('scope', 'blog')->where('status', 'published')->firstOrFail();

        $post = Post::where('slug', $post)
            ->where('scope', 'blog')
            ->where('status', 'published')
            ->where('category', optional($category)->id ?? null)
            ->where(function ($query) {
                $query->whereDate('available_from', '<=', now())->orWhere('available_from', null);
            })
            ->where(function ($query) {
                $query->whereDate('available_to', '>=', now())->orWhere('available_to', null);
            })
            ->firstOrFail();
            
        return Inertia::render('Blog/Post', [
            'post' => $post->load(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
        ]);
    }
}
