<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return response()->json([
            'status' => true,
            'message' => 'Role assigned successfully',
            'data' => $user->getRoleNames(),
        ]);
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

        return response()->json([
            'status' => true,
            'message' => 'Permissions assigned directly to user',
            'data' => $user->permissions,
        ]);
    }

    // Get user roles
    public function getUserRoles($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return response()->json([
            'status' => true,
            'roles' => $user->getRoleNames(),
        ]);
    }

    // Get user permissions (including via roles)
    public function getUserPermissions($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return response()->json([
            'status' => true,
            'permissions' => $user->getAllPermissions(),
        ]);
    }
}
