<?php

namespace App\Domains\RBAC\Controllers\Api;

use App\Domains\RBAC\Models\Permission;
use App\Domains\RBAC\Services\Audit;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class PermissionController extends BaseApiController
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function index()
    {
        $permissions = Permission::all()->groupBy('module');

        return $this->success($permissions, 'permissions_fetched');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name',
            'module' => 'required|string',
            'justification' => 'nullable|string',
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'api',
            'module' => $validated['module'],
        ]);

        $this->audit->log([
            'event_type' => 'permission_created',
            'target_role' => null,
            'permission' => $permission->name,
            'old_value' => null,
            'new_value' => $permission->toArray(),
            'justification' => $validated['justification'] ?? null,
        ]);

        return $this->success($permission, 'permission_created', 201);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id,
            'module' => 'required|string',
            'justification' => 'nullable|string',
        ]);

        $old = $permission->toArray();

        $permission->update([
            'name' => $validated['name'],
            'module' => $validated['module'],
        ]);

        $this->audit->log([
            'event_type' => 'permission_updated',
            'target_role' => null,
            'permission' => $permission->name,
            'old_value' => $old,
            'new_value' => $permission->toArray(),
            'justification' => $validated['justification'] ?? null,
        ]);

        return $this->success($permission, 'permission_updated');
    }

    public function destroy(Request $request, Permission $permission)
    {
        $old = $permission->toArray();
        $permissionName = $permission->name;

        $permission->delete();

        $this->audit->log([
            'event_type' => 'permission_deleted',
            'target_role' => null,
            'permission' => $permissionName,
            'old_value' => $old,
            'new_value' => null,
            'justification' => $request->justification,
        ]);

        return $this->success(null, 'permission_deleted');
    }
}
