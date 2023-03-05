<?php

namespace App\Http\Controllers\Apps\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Blog/Index', [
            'posts' => Post::getPublished('blog', request()->user() ?? null, ['roles' => 'all'])
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

        $post = Post::getPublished('blog', request()->user() ?? null, ['roles' => 'all', 'slug' => $postSlug, 'category' => $categoryId])->firstOrFail();
            
        return Inertia::render('Apps/Blog/Show', [
            'post' => $post
        ]);
    }
}
