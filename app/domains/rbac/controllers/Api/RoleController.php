<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Services\Audit;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends BaseApiController
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    // Index / Show
    public function index(?Role $role = null)
    {
        if ($role) {
            return $this->success($role, 'role_fetched');
        }

        $roles = Role::with('permissions')->get();

        return $this->success($roles, 'roles_fetched');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
            'justification' => 'nullable|string',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'api',
        ]);

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'role_created',
            'target_role' => $role->name,
            'permission' => null,
            'old_value' => null,
            'new_value' => $role->toArray(),
            'justification' => $validated['justification'] ?? null,
        ]);

        return $this->success($role, 'role_created', 201);
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'justification' => 'nullable|string',
        ]);

        $old = $role->toArray();

        $role->update([
            'name' => $validated['name'],
        ]);

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'role_updated',
            'target_role' => $role->name,
            'permission' => null,
            'old_value' => $old,
            'new_value' => $role->toArray(),
            'justification' => $validated['justification'] ?? null,
        ]);

        return $this->success($role, 'role_updated');
    }

    public function destroy(Request $request, Role $role)
    {
        $old = $role->toArray();
        $roleName = $role->name;

        $role->delete();

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'role_deleted',
            'target_role' => $roleName,
            'permission' => null,
            'old_value' => $old,
            'new_value' => null,
            'justification' => $request->justification,
        ]);

        return $this->success(null, 'role_deleted');
    }
}
