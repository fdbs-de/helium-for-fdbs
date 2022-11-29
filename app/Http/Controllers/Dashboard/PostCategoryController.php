<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategories\CreatePostCategoryRequest;
use App\Http\Requests\PostCategories\DestroyPostCategoryRequest;
use App\Http\Requests\PostCategories\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function store(CreatePostCategoryRequest $request)
    {
        PostCategory::create($request->validated());

        return back();
    }

    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory->update($request->validated());

        return back();
    }

    public function delete(DestroyPostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory->delete();

        return back();
    }
}
