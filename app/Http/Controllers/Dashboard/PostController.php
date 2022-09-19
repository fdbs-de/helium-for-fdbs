<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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

    public function destroy(DestroyPostRequest $request, Post $post)
    {
        $post->delete();

        return back();
    }
}
