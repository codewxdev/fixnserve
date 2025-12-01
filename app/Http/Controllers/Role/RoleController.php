<?php

namespace App\Http\Controllers\Role;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // Index / Show
    public function index(?Role $role = null)
    {
        if ($role) {
            return ApiResponse::success($role, 'Role fetched successfully');
        }
        $roles = Role::all();

        return ApiResponse::success($roles, 'Roles fetched successfully');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);

        return ApiResponse::success($role, 'Role created', 201);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|unique:roles,name,'.$role->id]);
        $role->update(['name' => $request->name]);

        return ApiResponse::success($role, 'Role updated');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return ApiResponse::success(null, 'Role deleted');
    }


}
