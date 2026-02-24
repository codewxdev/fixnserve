<?php

use App\Domains\RBAC\Controllers\Api\PermissionController;
use App\Domains\RBAC\Controllers\Api\RoleController;
use App\Domains\RBAC\Controllers\Api\RolePermissionController;
use App\Domains\RBAC\Controllers\Api\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {

    // Main Authenticated Routes Group with User Status Check
    Route::middleware(['auth:api', 'user.active', 'active.session', 'validate.session', 'network.security'])->group(function () {

        // Super Admin Routes (with additional checks)
        Route::middleware(['role:Super Admin', '2fa'])->group(function () {
            Route::apiResource('roles', RoleController::class);
            Route::apiResource('permissions', PermissionController::class);
            Route::post('/role-permission', [RolePermissionController::class, 'assignPermission']);
            Route::delete('/role-permission', [RolePermissionController::class, 'removePermission']);
            Route::get('/role-permission/{role}', [RolePermissionController::class, 'getPermissions']);
            Route::prefix('users')->group(function () {
                Route::post('/assign-role', [UserRoleController::class, 'assignRole']);
                Route::post('/assign-permissions', [UserRoleController::class, 'assignPermissionsToUser']);
                Route::get('/{id}/roles', [UserRoleController::class, 'getUserRoles']);
                Route::get('/{id}/permissions', [UserRoleController::class, 'getUserPermissions']);
            });

        });

    });

});

// Route::apiResource('roles', RoleController::class);
// Route::apiResource('permissions', PermissionController::class);
// Route::post('/assign-role', [UserRoleController::class, 'assignRole']);
// Route::post('/assign-permissions', [UserRoleController::class, 'assignPermissionsToUser']);
// Route::post('/role-permission', [RolePermissionController::class, 'assignPermission']);
