<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\CreateRoleRequest;
use App\Http\Requests\Roles\DestroyRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Roles/Index', [
            'items' => Role::with('permissions')->orderBy('created_at')->get(),
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
