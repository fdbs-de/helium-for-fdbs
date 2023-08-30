<?php

namespace App\Http\Controllers\Apps\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        $query = Post::query();

        $query
        // Posts that are published and available to the user
        ->where(function ($query) {
            $query
            ->whereScope(['blog'])
            ->wherePublished()
            ->whereAvailable();
        })
        // Posts that may not be published (drafts; only visible to editors and admins)
        ->orWhere(function ($query) {
            $query
            ->whereScope(['blog'])
            ->whereEditable();
        });



        // START: Order
        $query
        ->orderByDesc('pinned')
        ->orderByDesc('created_at')
        ->orderByDesc('updated_at');
        // END: Order



        return Inertia::render('Apps/Blog/Index', [
            'posts' => PostResource::collection($query->get()),
        ]);
    }

    public function show($postSlug)
    {
        $query = Post::query();

        $query
        ->where('slug', $postSlug)
        ->where(function ($query) {
            $query
            // Posts that are published and available to the user
            ->where(function ($query) {
                $query
                ->whereScope(['blog'])
                ->wherePublished()
                ->whereAvailable();
            })
            // Posts that may not be published (drafts; only visible to editors and admins)
            ->orWhere(function ($query) {
                $query
                ->whereScope(['blog'])
                ->whereEditable();
            });
        });
            
        return Inertia::render('Apps/Blog/Show', [
            'post' => PostResource::make($query->firstOrFail())
        ]);
    }
}
