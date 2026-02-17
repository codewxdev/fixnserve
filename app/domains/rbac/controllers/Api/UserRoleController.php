<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Domains\Security\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_uuid' => 'required|exists:users,uuid',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::where('uuid', $request->user_uuid)->firstOrFail();
        $user->syncRoles([$request->role]); // overwrite roles

        return ApiResponse::success($user->getRoleNames(), 'Role assigned successfully');
    }

    // Assign direct permissions to user (optional)
    public function assignPermissionsToUser(Request $request)
    {
        $request->validate([
            'user_uuid' => 'required|exists:users,uuid',
            'permissions' => 'required|array',
        ]);

        $user = User::where('uuid', $request->user_uuid)->firstOrFail();
        $user->syncPermissions($request->permissions);

        return ApiResponse::success($user->permissions, 'Permissions assigned directly to user');
    }

    // Get user roles
    public function getUserRoles($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return ApiResponse::success($user->getRoleNames(), 'User roles fetched successfully');
    }

    // Get user permissions (including via roles)
    public function getUserPermissions($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return ApiResponse::success($user->getAllPermissions(), 'User permissions fetched successfully');
    }
}
