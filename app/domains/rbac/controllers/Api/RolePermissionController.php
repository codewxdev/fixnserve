<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Services\Audit;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends BaseApiController
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function assignPermission(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'present|array',
            'justification' => 'nullable|string',
        ]);

        $role = Role::findByName($validated['role'], 'api');

        $oldPermissions = $role->permissions->pluck('name')->toArray();

        $role->syncPermissions($validated['permissions']);

        $newPermissions = $role->permissions->pluck('name')->toArray();

        $added = array_values(array_diff($newPermissions, $oldPermissions));
        $removed = array_values(array_diff($oldPermissions, $newPermissions));

        // 🔐 Audit
        $this->audit->log([
            'event_type' => 'permissions_synced',
            'target_role' => $role->name,
            'permission' => null,
            'old_value' => $oldPermissions,
            'new_value' => $newPermissions,
            'justification' => $validated['justification'] ?? null,
        ]);

        if (! empty($added)) {
            $this->audit->log([
                'event_type' => 'permission_assigned',
                'target_role' => $role->name,
                'permission' => json_encode($added),
                'old_value' => null,
                'new_value' => $added,
                'justification' => $validated['justification'] ?? null,
            ]);
        }

        if (! empty($removed)) {
            $this->audit->log([
                'event_type' => 'permission_removed',
                'target_role' => $role->name,
                'permission' => json_encode($removed),
                'old_value' => $removed,
                'new_value' => null,
                'justification' => $validated['justification'] ?? null,
            ]);
        }

        return $this->success($newPermissions, 'permissions_synced');
    }

    public function removePermission(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'required|array',
            'justification' => 'nullable|string',
        ]);

        $role = Role::findByName($validated['role'], 'api');

        $oldPermissions = $role->permissions->pluck('name')->toArray();

        $role->revokePermissionTo($validated['permissions']);

        $newPermissions = $role->permissions->pluck('name')->toArray();

        $this->audit->log([
            'event_type' => 'permission_removed',
            'target_role' => $role->name,
            'permission' => json_encode($validated['permissions']),
            'old_value' => $oldPermissions,
            'new_value' => $newPermissions,
            'justification' => $validated['justification'] ?? null,
        ]);

        return $this->success($newPermissions, 'permissions_removed');
    }

    public function getPermissions($role)
    {
        $role = Role::with('permissions')->findOrFail($role);

        $grouped = $role->permissions
            ->groupBy('module')
            ->map(function ($permissions) {
                return $permissions->pluck('name');
            });

        return $this->success($grouped, 'role_permissions_fetched');
    }

    public function assignModuleToRole(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
            'module' => 'required|string',
        ]);

        $role = Role::findByName($validated['role'], 'api');

        $permissions = Permission::where('module', $validated['module'])
            ->pluck('name')
            ->toArray();

        $role->givePermissionTo($permissions);

        return $this->success([
            'module' => $validated['module'],
            'permissions' => $permissions,
        ], 'module_assigned_to_role');
    }
}
