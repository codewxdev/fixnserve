<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    // Assign permissions to role
    public function assignPermission(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'required|array',
        ]);

        $role = Role::findByName($request->role, 'api');
        $role->syncPermissions($request->permissions);

        return ApiResponse::success($role->permissions, 'Permissions assigned');
    }

    // Remove specific permissions
    public function removePermission(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'required|array',
        ]);

        $role = Role::findByName($request->role, 'api');
        $role->revokePermissionTo($request->permissions);

        return ApiResponse::success($role->permissions, 'Permissions removed');
    }

    // Get all permissions of a role
    public function getPermissions($role)
    {
        $role = Role::findByName($role, 'api');

        return ApiResponse::success($role->permissions, 'Role permissions fetched');
    }
}
