<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WikiController extends Controller
{
    public function overview()
    {
        return Inertia::render('Wiki/Overview', [
            'posts' => Post::with(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
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
        ]);
    }
}
