<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Services\Audit;
use App\Domains\Security\Models\User;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_uuid' => 'required|exists:users,uuid',
            'role' => 'required|exists:roles,name',
            'justification' => 'nullable|string',
        ]);

        $user = User::where('uuid', $request->user_uuid)->firstOrFail();

        // OLD ROLES
        $oldRoles = $user->getRoleNames()->toArray();

        // Sync role (overwrite)
        $user->syncRoles([$request->role]);

        // NEW ROLES
        $newRoles = $user->getRoleNames()->toArray();

        // Diff
        $added = array_values(array_diff($newRoles, $oldRoles));
        $removed = array_values(array_diff($oldRoles, $newRoles));

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'user_role_updated',
            'target_user' => $user->uuid,
            'old_value' => $oldRoles,
            'new_value' => $newRoles,
            'justification' => $request->justification,
        ]);

        if (! empty($added)) {
            $this->audit->log([
                'event_type' => 'role_assigned_to_user',
                'target_user' => $user->uuid,
                'permission' => json_encode($added),
                'justification' => $request->justification,
            ]);
        }

        if (! empty($removed)) {
            $this->audit->log([
                'event_type' => 'role_removed_from_user',
                'target_user' => $user->uuid,
                'permission' => json_encode($removed),
                'justification' => $request->justification,
            ]);
        }

        return ApiResponse::success(
            $newRoles,
            'Role assigned successfully'
        );
    }

    public function assignPermissionsToUser(Request $request)
    {
        $request->validate([
            'user_uuid' => 'required|exists:users,uuid',
            'permissions' => 'required|array',
            'justification' => 'nullable|string',
        ]);

        $user = User::where('uuid', $request->user_uuid)->firstOrFail();

        // OLD PERMISSIONS
        $oldPermissions = $user->permissions->pluck('name')->toArray();

        // Sync permissions
        $user->syncPermissions($request->permissions);

        // NEW PERMISSIONS
        $newPermissions = $user->permissions->pluck('name')->toArray();

        // Diff
        $added = array_values(array_diff($newPermissions, $oldPermissions));
        $removed = array_values(array_diff($oldPermissions, $newPermissions));

        $this->audit->log([
            'event_type' => 'user_permissions_updated',
            'target_user' => $user->uuid,
            'old_value' => $oldPermissions,
            'new_value' => $newPermissions,
            'justification' => $request->justification,
        ]);

        return ApiResponse::success(
            $newPermissions,
            'Permissions assigned directly to user'
        );
    }

    public function getUserRoles($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return ApiResponse::success(
            $user->getRoleNames(),
            'User roles fetched successfully'
        );
    }

    public function getUserPermissions($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return ApiResponse::success(
            $user->getAllPermissions(),
            'User permissions fetched successfully'
        );
    }
}
