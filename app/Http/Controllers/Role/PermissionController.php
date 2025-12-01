<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index(?Permission $permission = null)
    {
        if ($permission) {
            return ApiResponse::success($permission, 'Permission fetched');
        }

        return ApiResponse::success(Permission::all(), 'Permissions fetched');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        $permission = Permission::create(['name' => $request->name, 'guard_name' => 'api']);

        return ApiResponse::success($permission, 'Permission created', 201);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,'.$permission->id]);
        $permission->update(['name' => $request->name]);

        return ApiResponse::success($permission, 'Permission updated');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return ApiResponse::success(null, 'Permission deleted');
    }
}
