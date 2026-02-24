<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Models\Permission;
use App\Domains\RBAC\Services\Audit;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    // public function index(?Permission $permission = null)
    // {
    //     if ($permission) {
    //         return ApiResponse::success($permission, 'Permission fetched');
    //     }

    //     return ApiResponse::success(Permission::all(), 'Permissions fetched');
    // }

    public function index()
    {
        $permissions = Permission::all()->groupBy('module'); // Group by module

        return ApiResponse::success($permissions, 'Permissions fetched by module');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'module' => 'required|string', // ✅ Add module
            'justification' => 'nullable|string',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'api',
            'module' => $request->module, // ✅ Save module
        ]);

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'permission_created',
            'target_role' => null,
            'permission' => $permission->name,
            'old_value' => null,
            'new_value' => ['name' => $permission->name],
            'justification' => $request->justification,
        ]);

        return ApiResponse::success($permission, 'Permission created', 201);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id,
            'module' => 'required|string',
            'justification' => 'nullable|string',
        ]);

        $old = $permission->toArray();

        $permission->update([
            'name' => $request->name,
            'module' => $request->module,
        ]);

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'permission_updated',
            'target_role' => null,
            'permission' => $permission->name,
            'old_value' => $old,
            'new_value' => $permission->toArray(),
            'justification' => $request->justification,
        ]);

        return ApiResponse::success($permission, 'Permission updated');
    }

    public function destroy(Request $request, Permission $permission)
    {
        $old = $permission->toArray();

        $permissionName = $permission->name;

        $permission->delete();

        // 🔐 Audit Log
        $this->audit->log([
            'event_type' => 'permission_deleted',
            'target_role' => null,
            'permission' => $permissionName,
            'old_value' => $old,
            'new_value' => null,
            'justification' => $request->justification,
        ]);

        return ApiResponse::success(null, 'Permission deleted');
    }
}
