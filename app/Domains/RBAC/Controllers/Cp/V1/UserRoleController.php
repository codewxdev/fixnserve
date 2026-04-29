<?php

namespace App\Domains\RBAC\Controllers\Cp\V1;

use App\Domains\RBAC\Services\Audit;
use App\Domains\Security\Models\User;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class UserRoleController extends BaseApiController
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function assignRole(Request $request)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|exists:users,uuid',
            'role' => 'required|exists:roles,name',
            'justification' => 'nullable|string',
        ]);

        $user = User::where('uuid', $validated['user_uuid'])->firstOrFail();

        // OLD ROLES
        $oldRoles = $user->getRoleNames()->toArray();

        // Sync role
        $user->syncRoles([$validated['role']]);

        // NEW ROLES
        $newRoles = $user->getRoleNames()->toArray();

        $added = array_values(array_diff($newRoles, $oldRoles));
        $removed = array_values(array_diff($oldRoles, $newRoles));

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'user_role_updated',
            'target_user' => $user->uuid,
            'old_value' => $oldRoles,
            'new_value' => $newRoles,
            'justification' => $validated['justification'] ?? null,
        ]);

        if (! empty($added)) {
            $this->audit->log([
                'event_type' => 'role_assigned_to_user',
                'target_user' => $user->uuid,
                'permission' => json_encode($added),
                'justification' => $validated['justification'] ?? null,
            ]);
        }

        if (! empty($removed)) {
            $this->audit->log([
                'event_type' => 'role_removed_from_user',
                'target_user' => $user->uuid,
                'permission' => json_encode($removed),
                'justification' => $validated['justification'] ?? null,
            ]);
        }

        return $this->success($newRoles, 'role_assigned_to_user');
    }

    public function assignPermissionsToUser(Request $request)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|exists:users,uuid',
            'permissions' => 'required|array',
            'justification' => 'nullable|string',
        ]);

        $user = User::where('uuid', $validated['user_uuid'])->firstOrFail();

        $oldPermissions = $user->permissions->pluck('name')->toArray();

        $user->syncPermissions($validated['permissions']);

        $newPermissions = $user->permissions->pluck('name')->toArray();

        $added = array_values(array_diff($newPermissions, $oldPermissions));
        $removed = array_values(array_diff($oldPermissions, $newPermissions));

        $this->audit->log([
            'event_type' => 'user_permissions_updated',
            'target_user' => $user->uuid,
            'old_value' => $oldPermissions,
            'new_value' => $newPermissions,
            'justification' => $validated['justification'] ?? null,
        ]);

        return $this->success($newPermissions, 'user_permissions_assigned');
    }

    public function getUserRoles($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return $this->success($user->getRoleNames(), 'user_roles_fetched');
    }

    public function getUserPermissions($id)
    {
        $user = User::where('uuid', $id)->firstOrFail();

        return $this->success($user->getAllPermissions(), 'user_permissions_fetched');
    }
}
