<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Services\Audit;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
            return ApiResponse::success($role, 'Role fetched successfully');
        }

        $roles = Role::with('permissions')->get();

        return response()->json([
            'data' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'justification' => 'nullable|string',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'api',
        ]);

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'role_created',
            'target_role' => $role->name,
            'permission' => null,
            'old_value' => null,
            'new_value' => $role->toArray(),
            'justification' => $request->justification,
        ]);

        return ApiResponse::success($role, 'Role created', 201);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'justification' => 'nullable|string',
        ]);

        $old = $role->toArray();

        $role->update([
            'name' => $request->name,
        ]);

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'role_updated',
            'target_role' => $role->name,
            'permission' => null,
            'old_value' => $old,
            'new_value' => $role->toArray(),
            'justification' => $request->justification,
        ]);

        return ApiResponse::success($role, 'Role updated');
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

        return ApiResponse::success(null, 'Role deleted');
    }
}
