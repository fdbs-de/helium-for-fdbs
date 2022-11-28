<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Admin/Posts', [
            'posts' => Post::orderBy('created_at', 'desc')->get(),
            'categories' => PostCategory::orderBy('name', 'asc')->get(),
        ]);
    }

    public function store(CreatePostRequest $request)
    {
        Post::create($request->validated());

        return back();
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return back();
    }

    public function delete(DestroyPostRequest $request, Post $post)
    {
        $post->delete();

        return back();
    }
}
