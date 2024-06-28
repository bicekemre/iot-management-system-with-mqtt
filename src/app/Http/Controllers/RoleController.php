<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::query()->orderBy('id', 'desc')
            ->paginate(
                perPage: 10,
                page: 1
            );

        $permissions = Permission::all();

        return view('roles.index', compact('roles', 'permissions'));
    }

    public function items($offset, $limit)
    {
        $roles = Role::query()->orderBy('id', 'desc');

        if (\request()->has('search')) {
            $roles = $roles->where('name', 'like', '%' . \request('search') . '%');
        }
        $roles = $roles->paginate(
            perPage: $limit,
            page: $offset
        );

        return view('roles.data', compact('roles'));
    }

    public function create(Request $request)
    {
        $role = new \Spatie\Permission\Models\Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->guard_name = 'web';
        $role->save();

        foreach ($request->permissions as $permissionKey => $permissionValue) {
            if ($permissionValue == 'true') {
                $permission_id = Permission::query()->where('name', $permissionKey)->value('id');
                if ($permission_id) { // Ensure permission exists
                    $role->givePermissionTo($permission_id);
                }
            }
        }

        return response()->json($role);
    }

    public function edit($id)
    {
        $role = \Spatie\Permission\Models\Role::query()->findOrFail($id)->load('permissions');
        $permissions = Permission::all();
        $rolePermissions = [];
        foreach ($permissions as $permission) {
            $rolePermissions[$permission->name] = (bool)$role->hasPermissionTo($permission->name);
        }
        return response()->json([
            'name' => $role->name,
            'description' => $role->description,
            'permissions' => $rolePermissions,
        ]);

    }

    public function update(Request $request, $id)
    {
        $role = \Spatie\Permission\Models\Role::query()->findOrFail($id);

        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        foreach ($request->permissions as $permissionKey => $permissionValue) {
            if ($permissionValue == 'true') {
                $permission_id = Permission::query()->where('name', $permissionKey)->value('id');
                if ($permission_id) { // Ensure permission exists
                    $role->givePermissionTo($permission_id);
                }
            }
        }

        return response()->json($role);
    }

    public function delete($id)
    {
        $role = \Spatie\Permission\Models\Role::query()->findOrFail($id);

        $role->delete();

        return response()->json(['success' => true]);
    }
}
