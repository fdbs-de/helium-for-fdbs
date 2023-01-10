<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\DuplicatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Apps/Blog/Index', [
            'posts' => Post::with(['category' => function ($query) {
                $query->select('id', 'name');
            }])->orderBy('scope')->orderBy('created_at', 'desc')->get(),
            'categories' => PostCategory::withCount('posts')->orderBy('name', 'asc')->get(),
        ]);
    }



    public function create(Post $post)
    {
        return Inertia::render('Admin/Apps/Blog/Create', [
            'post' => $post,
            'categories' => PostCategory::orderBy('name', 'asc')->get(),
        ]);
    }



    public function store(CreatePostRequest $request)
    {
        $post = Post::create($request->validated());

        return redirect()->route('admin.posts.editor', $post);
    }



    public function duplicate(DuplicatePostRequest $request, Post $post)
    {
        $post = $post->duplicate();

        if ($request->returnTo === 'editor')
        {
            return redirect()->route('admin.posts.editor', $post);
        }

        return back();
    }



    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return redirect()->route('admin.posts.editor', $post);
    }



    public function delete(DestroyPostRequest $request)
    {
        Post::whereIn('id', $request->ids)->delete();

        return back();
    }
}
