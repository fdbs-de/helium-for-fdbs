<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\Roles\DestroyRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Permissions\Permissions;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Roles/Index', [
            'items' => Role::with('permissions')->orderBy('created_at')->get(),
            'permissions' => Permissions::GROUPED_PERMISSIONS,
        ]);
    }



    public function searchPublic(Request $request)
    {
        $query = null;

        // START: Scope
        switch ($request->filter['scope'] ?? null)
        {
            case 'user-exact': $query = $request->user()->roles(); break;
            case 'user-available': $query = $request->user()->availableRoles(); break;
        }

        if ($query === null) throw new \Exception('Invalid scope');
        // END: Scope
        
        // START: Search
        if (array_key_exists('search', $request->filter) && $request->filter['search'])
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('name', $request->filter['search']);
            });
        }
        // END: Search



        // START: Filter
        if (array_key_exists('exclude', $request->filter) && $request->filter['exclude'])
        {
            $query->whereNotIn('id', $request->filter['exclude']);
        }
        // END: Filter



        // START: Sort
        $field = $request->sort['field'] ?? 'name';
        $order = $request->sort['order'] ?? 'asc';

        $query->orderBy($field, $order);
        // END: Sort



        // START: Pagination
        $total = $query->count();

        $limit = $request->pagination['size'] ?? 20;
        $offset = $request->pagination['size'] * ($request->pagination['page'] ?? 0) - $request->pagination['size'];

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);

        $query->limit($limit)->offset($offset);
        // END: Pagination



        return response()->json([
            'data' => $query->get(),
            'total' => $total,
        ]);
    }



    public function store(CreateRoleRequest $request)
    {
        $role = Role::create($request->validated());

        $role->syncPermissions($request->permissions);

        return back();
    }



    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        $role->syncPermissions($request->permissions);

        return back();
    }



    public function delete(DestroyRoleRequest $request, Role $role)
    {
        $role->delete();

        return back();
    }
}
