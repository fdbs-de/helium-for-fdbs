<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategories\CreatePostCategoryRequest;
use App\Http\Requests\PostCategories\DestroyPostCategoryRequest;
use App\Http\Requests\PostCategories\DuplicatePostCategoryRequest;
use App\Http\Requests\PostCategories\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class PostCategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/PostCategories/Index', [
            'categories' => PostCategory::withCount('posts')->orderBy('scope')->orderBy('name', 'asc')->get(),
        ]);
    }



    public function create(PostCategory $category)
    {
        return Inertia::render('Admin/PostCategories/Create', [
            'item' => $category->load(['roles']),
            'roles' => Role::orderBy('created_at')->get(),
        ]);
    }



    public function store(CreatePostCategoryRequest $request)
    {
        $postCategory = PostCategory::create($request->validated());
        $postCategory->roles()->sync($request->roles);

        return redirect()->route('admin.categories.editor', $postCategory);
    }



    public function duplicate(DuplicatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory = $postCategory->duplicate();

        if ($request->returnTo === 'editor')
        {
            return redirect()->route('admin.categories.editor', $postCategory);
        }

        return back();
    }



    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory->update($request->validated());
        $postCategory->roles()->sync($request->roles);

        return redirect()->route('admin.categories.editor', $postCategory);
    }



    public function delete(DestroyPostCategoryRequest $request)
    {
        PostCategory::whereIn('id', $request->ids)->delete();

        return back();
    }
}
