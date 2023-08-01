<?php

namespace App\Http\Controllers\Apps\SharedAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategories\CreatePostCategoryRequest;
use App\Http\Requests\PostCategories\DestroyPostCategoryRequest;
use App\Http\Requests\PostCategories\DuplicatePostCategoryRequest;
use App\Http\Requests\PostCategories\UpdatePostCategoryRequest;
use App\Http\Resources\PostCategory\PostCategoryResource;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class PostCategoryController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Apps/SharedAdmin/Categories/Index', [
            'categories' => PostCategory::withCount('posts')
            ->where('scope', $request->app['id'])
            ->orderBy('name', 'asc')
            ->get(),
            'app' => $request->app['route'],
        ]);
    }



    public function search(Request $request)
    {
        $query = PostCategory::getPublished($request->app['id'], 'all', [], false);

        // START: Search
        if ($request->search) {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                    ->orWhereFuzzy('name', $request->search)
                    ->orWhereFuzzy('slug', $request->search)
                    ->orWhereFuzzy('description', $request->search);
            });
        }
        // END: Search



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';

        $query->orderBy($field, $order);
        // END: Sort



        // START: Pagination
        $total = $query->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);

        $query->limit($limit)->offset($offset);
        // END: Pagination

        return response()->json([
            'data' => PostCategoryResource::collection($query->get()),
            'total' => $total,
        ]);
    }



    public function create(Request $request, PostCategory $category)
    {
        return Inertia::render('Apps/SharedAdmin/Categories/Create', [
            'item' => $category->load(['roles']),
            'roles' => Role::orderBy('created_at')->get(),
            'app' => $request->app['route'],
        ]);
    }



    public function store(CreatePostCategoryRequest $request)
    {
        $postCategory = PostCategory::create($request->validated());
        $postCategory->roles()->sync($request->roles);

        return redirect()->route('admin.'.$request->app['route'].'.categories.editor', $postCategory);
    }



    public function duplicate(DuplicatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory = $postCategory->duplicate();

        if ($request->returnTo === 'editor')
        {
            return redirect()->route('admin.'.$request->app['route'].'.categories.editor', $postCategory);
        }

        return back();
    }



    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $postCategory->update($request->validated());
        $postCategory->roles()->sync($request->roles);

        return redirect()->route('admin.'.$request->app['route'].'.categories.editor', $postCategory);
    }



    public function delete(DestroyPostCategoryRequest $request)
    {
        PostCategory::whereIn('id', $request->ids)->delete();

        return back();
    }
}
