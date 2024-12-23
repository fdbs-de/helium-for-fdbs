<?php

namespace App\Http\Controllers\Apps\PagesAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Planner\CreatePlannerPostGroupRequest;
use App\Http\Requests\Planner\UpdatePlannerPostGroupRequest;
use App\Http\Resources\Planner\PostGroupResource;
use App\Models\PlannerPostGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlannerController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Apps/PagesAdmin/Planner/Index');
    }



    public function search(Request $request)
    {
        $query = PlannerPostGroup::query();

        // START: Search
        if ($request->search) {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                    ->orWhereFuzzy('title', $request->search)
                    ->orWhereFuzzy('slug', $request->search);
            });
        }
        // END: Search



        // START: Filter
        if ($request->status) {
        }
        // END: Filter



        // START: Sort
        $field = $request->sort['field'] ?? 'created_at';
        $order = $request->sort['order'] ?? 'desc';

        $query->orderBy($field, $order);
        // END: Sort



        // START: Identifiers
        $ids = $query->pluck('planner_post_groups.id')->toArray();
        // END: Identifiers



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
            'data' => PostGroupResource::collection($query->get()),
            'item_ids' => $ids,
            'total' => $total,
        ]);
    }



    public function create(PlannerPostGroup $group)
    {
        return Inertia::render('Apps/PagesAdmin/Planner/Create', [
            'item' => PostGroupResource::make($group),
        ]);
    }



    public function store(CreatePlannerPostGroupRequest $request)
    {
        $group = PlannerPostGroup::create($request->validated());

        return redirect()->route('admin.pages.planner.editor', PostGroupResource::make($group));
    }



    public function update(UpdatePlannerPostGroupRequest $request, PlannerPostGroup $group)
    {
        $group->update($request->validated());

        return redirect()->route('admin.pages.planner.editor', PostGroupResource::make($group));
    }
}
