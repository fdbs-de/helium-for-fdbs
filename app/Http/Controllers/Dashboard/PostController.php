<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\DestroyPostRequest;
use App\Http\Requests\Posts\DuplicatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Apps/Shared/Posts/Index', [
            'app' => $request->app['route'],
        ]);
    }



    public function search(Request $request)
    {
        $search = $request->search ? ['query' => $request->search] : [];
        
        $query = Post::getPublished($request->app['id'], request()->user(), $search, false)
        ->with(['category' => function ($query) {
            $query->select('id', 'name', 'color', 'icon');
        }]);

        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);

        $data = $query->orderBy('created_at', 'desc')->limit($limit)->offset($offset)->get();

        return response()->json([
            'data' => $data,
            'total' => $total,
        ]);
    }



    public function create(Request $request)
    {
        $post = $request->post ? new PostResource(Post::find($request->post)) : null;

        return Inertia::render('Admin/Apps/Shared/Posts/Create', [
            'item' => $post,
            'categories' => PostCategory::orderBy('created_at')
            ->where('scope', $request->app['id'])
            ->orderBy('name', 'asc')
            ->get(),
            'roles' => Role::orderBy('name', 'asc')->get(),
            'app' => $request->app['route'],
        ]);
    }



    public function store(CreatePostRequest $request)
    {
        // Create the post
        $post = Post::create($request->validated());

        // Sync the roles (if override is enabled)
        $post->roles()->sync($request->override_category_roles ? $request->roles : []);

        // Sync the authors, editors, etc.
        $post->users()->sync($request->users);

        // Attach the current user as an author
        $post->users()->syncWithoutDetaching(auth()->user()->id, ['role' => 'author']);

        // Redirect to the editor
        return redirect()->route('admin.'.$request->app['route'].'.posts.editor', $post);
    }



    public function duplicate(DuplicatePostRequest $request, Post $post)
    {
        $post = $post->duplicate();

        // Sync the current user as an author
        $post->users()->sync(auth()->user()->id, ['role' => 'author']);

        if ($request->returnTo === 'editor')
        {
            return redirect()->route('admin.'.$request->app['route'].'.posts.editor', $post);
        }

        return back();
    }



    public function update(UpdatePostRequest $request, Post $post)
    {
        // Update the post
        $post->update($request->validated());

        // Sync the roles (if override is enabled)
        $post->roles()->sync($request->override_category_roles ? $request->roles : []);

        // Sync the authors, editors, etc.
        $post->users()->sync($request->users);

        // Redirect to the editor
        return redirect()->route('admin.'.$request->app['route'].'.posts.editor', $post);
    }



    public function delete(DestroyPostRequest $request)
    {
        Post::whereIn('id', $request->ids)->delete();

        return back();
    }
}
