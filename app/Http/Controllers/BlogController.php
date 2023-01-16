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
            'posts' => Post::getPublished('blog')
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),
        ]);
    }

    public function show($categorySlug, $postSlug)
    {
        $category = ($categorySlug === '-') ? null : PostCategory::where('slug', $categorySlug)->where('scope', 'blog')->where('status', 'published')->firstOrFail();
        $categoryId = optional($category)->id ?? null;

        $post = Post::getPublishedBySlugAndCategory($postSlug, $categoryId, 'blog')->firstOrFail();
            
        return Inertia::render('Blog/Post', [
            'post' => $post
        ]);
    }
}
