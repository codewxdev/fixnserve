<?php

namespace App\Http\Controllers\Role;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
// use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    // Assign permissions to role
    public function assignPermission(Request $request)
    {
        // dd($request);
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
        $role = Role::find($role, 'id');

        return ApiResponse::success($role->permissions, 'Role permissions fetched');
    }
}
