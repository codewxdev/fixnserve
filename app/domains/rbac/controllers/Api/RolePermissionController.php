<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Services\Audit;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function assignPermission(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'present|array',
            'justification' => 'nullable|string',
        ]);

        $role = Role::findByName($request->role, 'api');

        // OLD STATE
        $oldPermissions = $role->permissions->pluck('name')->toArray();

        // Sync permissions
        $role->syncPermissions($request->permissions);

        // NEW STATE
        $newPermissions = $role->permissions->pluck('name')->toArray();

        // Calculate diff
        $added = array_values(array_diff($newPermissions, $oldPermissions));
        $removed = array_values(array_diff($oldPermissions, $newPermissions));

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'permissions_synced',
            'target_role' => $role->name,
            'permission' => null,
            'old_value' => $oldPermissions,
            'new_value' => $newPermissions,
            'justification' => $request->justification,
        ]);

        // Optional: log detailed changes separately
        if (! empty($added)) {
            $this->audit->log([
                'event_type' => 'permission_assigned',
                'target_role' => $role->name,
                'permission' => json_encode($added),
                'old_value' => null,
                'new_value' => $added,
                'justification' => $request->justification,
            ]);
        }

        if (! empty($removed)) {
            $this->audit->log([
                'event_type' => 'permission_removed',
                'target_role' => $role->name,
                'permission' => json_encode($removed),
                'old_value' => $removed,
                'new_value' => null,
                'justification' => $request->justification,
            ]);
        }

        return ApiResponse::success(
            $newPermissions,
            'Permissions synced successfully'
        );
    }

    public function removePermission(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'required|array',
            'justification' => 'nullable|string',
        ]);

        $role = Role::findByName($request->role, 'api');

        $oldPermissions = $role->permissions->pluck('name')->toArray();

        $role->revokePermissionTo($request->permissions);

        $newPermissions = $role->permissions->pluck('name')->toArray();

        $this->audit->log([
            'event_type' => 'permission_removed',
            'target_role' => $role->name,
            'permission' => json_encode($request->permissions),
            'old_value' => $oldPermissions,
            'new_value' => $newPermissions,
            'justification' => $request->justification,
        ]);

        return ApiResponse::success(
            $newPermissions,
            'Permissions removed'
        );
    }

    public function getPermissions($role)
    {
        $role = Role::with('permissions')->findOrFail($role);

        $grouped = $role->permissions
            ->groupBy('module')
            ->map(function ($permissions) {
                return $permissions->pluck('name');
            });

        return ApiResponse::success(
            $grouped,
            'Role permissions fetched module-wise'
        );
    }

    public function assignModuleToRole(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'module' => 'required|string',
        ]);

        $role = \Spatie\Permission\Models\Role::findByName($request->role, 'api');

        // Get all permissions of that module
        $permissions = \Spatie\Permission\Models\Permission::where('module', $request->module)
            ->pluck('name')
            ->toArray();

        // Assign all module permissions to role
        $role->givePermissionTo($permissions);

        return response()->json([
            'message' => 'Module assigned successfully',
            'module' => $request->module,
            'permissions' => $permissions,
        ]);
    }
}
