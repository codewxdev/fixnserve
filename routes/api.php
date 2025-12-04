<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetCodeController;
use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\Role\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('/password/forgot', [PasswordResetCodeController::class, 'sendResetCode']);
Route::post('/password/verify-code', [PasswordResetCodeController::class, 'verifyCode']);
Route::post('/password/reset', [PasswordResetCodeController::class, 'resetPassword']);
Route::post('/2fa/enable', [AuthController::class, 'enable2FA'])->middleware('auth:api');
Route::post('/2fa/verify', [AuthController::class, 'verify2FA'])->middleware('throttle:2fa');

Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

});

Route::middleware(['auth:api', 'role:Super Admin', '2fa'])->group(function () {

    Route::get('/roles/{role?}', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::post('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

    // Permissions CRUD
    Route::get('/permissions/{permission?}', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store']);
    Route::post('/permissions/{permission}', [PermissionController::class, 'update']);
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy']);

    // Role-Permission CRUD (assign/remove)
    Route::post('/role-permission', [RolePermissionController::class, 'assignPermission']);
    Route::delete('/role-permission', [RolePermissionController::class, 'removePermission']);
    Route::get('/role-permission/{role}', [RolePermissionController::class, 'getPermissions']);

    // USER → ROLE
    Route::post('/users/assign-role', [UserRoleController::class, 'assignRole']);

    // USER → DIRECT PERMISSIONS (optional)
    Route::post('/users/assign-permissions', [UserRoleController::class, 'assignPermissionsToUser']);
    // User roles + permissions
    Route::get('/users/{id}/roles', [UserRoleController::class, 'getUserRoles']);
    Route::get('/users/{id}/permissions', [UserRoleController::class, 'getUserPermissions']);

    Route::get('/login-history', [AuthController::class, 'loginHistory'])->middleware('auth:api', '2fa');

});
