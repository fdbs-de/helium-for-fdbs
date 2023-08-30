<?php

namespace App\Http\Controllers\Apps\Wiki;

use App\Http\Controllers\Controller;
use App\Http\Requests\Apps\Wiki\ViewPostRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\PostCategory\PostCategoryResource;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WikiController extends Controller
{
    public function overview(ViewPostRequest $request)
    {
        $query = Post::query();

        $query
        ->where(function ($query) {
            $query
            // Posts that are published and available to the user
            ->where(function ($query) {
                $query
                ->whereScope(['wiki'])
                ->wherePublished()
                ->whereAvailable();
            })
            // Posts that may not be published (drafts; only visible to editors and admins)
            ->orWhere(function ($query) {
                $query
                ->whereScope(['wiki'])
                ->whereEditable();
            });
        });



        // START: Search
        if ($request->search) {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('title', $request->search)
                ->orWhereFuzzy('slug', $request->search)
                ->orWhereFuzzy('content', $request->search)
                ->orWhereFuzzy('tags', $request->search);
            });
        }
        // END: Search

        
        // START: Filter
        if ($request->category && $request->category !== 'all')
        {
            $query->where('post_category_id', $request->category);
        }

        // END: Filter



        // START: Sort
        if (!$request->sort || $request->sort == 'all')
        {
            $query
            ->orderByDesc('pinned')
            ->orderBy('title');
        }
        
        // Fallback sort
        $query
        ->orderByDesc('created_at')
        ->orderByDesc('updated_at');
        // END: Sort



        // START: Limit
        if ($request->sort == 'recent')
        {
            $query->limit(12);
        }
        // END: Limit



        // START: Return
        return Inertia::render('Apps/Wiki/Overview', [
            'posts' => PostResource::collection($query->get()),
            'categories' => PostCategoryResource::collection(PostCategory::whereScope(['wiki'])->wherePublished()->whereAvailable()->orderBy('name')->get()),
        ]);
        // END: Return
    }

    public function show(ViewPostRequest $request)
    {
        $query = Post::query();

        $query
        ->where('slug', $request->postSlug)
        ->where(function ($query) {
            $query
            // Posts that are published and available to the user
            ->where(function ($query) {
                $query
                ->whereScope(['wiki'])
                ->wherePublished()
                ->whereAvailable();
            })
            // Posts that may not be published (drafts; only visible to editors and admins)
            ->orWhere(function ($query) {
                $query
                ->whereScope(['wiki'])
                ->whereEditable();
            });
        });


        return Inertia::render('Apps/Wiki/Show', [
            'post' => PostResource::make($query->firstOrFail()),
        ]);
    }
}
