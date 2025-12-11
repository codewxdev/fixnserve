<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetCodeController;
use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\Role\UserRoleController;
use App\Http\Controllers\ServiceProvider\CategoryController;
use App\Http\Controllers\ServiceProvider\PortfolioController;
use App\Http\Controllers\ServiceProvider\ServiceController;
use App\Http\Controllers\ServiceProvider\ServiceProviderController;
use App\Http\Controllers\ServiceProvider\SkillController;
use App\Http\Controllers\ServiceProvider\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('/password/forgot', [PasswordResetCodeController::class, 'sendResetCode']);
Route::post('/password/verify-code', [PasswordResetCodeController::class, 'verifyCode']);
Route::post('/password/reset', [PasswordResetCodeController::class, 'resetPassword']);
Route::post('/2fa/enable', [AuthController::class, 'enable2FA'])->middleware('auth:api');
Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);
Route::post('/update/profile/{id}', [AuthController::class, 'updateProfile']);
Route::post('/phone/verify', [AuthController::class, 'verifyPhoneOtp']);

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

    // -------------------------
    // CATEGORY CRUD
    // -------------------------
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // -------------------------
    // SUBCATEGORY CRUD
    // -------------------------
    Route::get('/subcategories', [SubcategoryController::class, 'index']);
    Route::post('/subcategories', [SubcategoryController::class, 'store']);
    Route::get('/subcategories/{id}', [SubcategoryController::class, 'show']);
    Route::post('/subcategories/{id}', [SubcategoryController::class, 'update']);
    Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy']);

    // -------------------------
    // SKILL CRUD
    // -------------------------
    Route::get('/skills', [SkillController::class, 'index']);
    Route::post('/skills', [SkillController::class, 'store']);
    Route::get('/skills/{id}', [SkillController::class, 'show']);
    Route::put('/skills/{id}', [SkillController::class, 'update']);
    Route::delete('/skills/{id}', [SkillController::class, 'destroy']);

    // / Update Service Status
    Route::put('/updateStatus', [ServiceController::class, 'updateStatus']);

});
Route::prefix('service-provider')->middleware('auth:api')->group(function () {
    // SERVICE CRUD
    // -------------------------
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    // -------------------------
    // SERVICE PROVIDER PROFILE SETUP
    // -------------------------

    Route::post('/categories-subcategories', [ServiceProviderController::class, 'saveCategoriesAndSubcategories']);

});
Route::prefix('skills')->group(function () {
    Route::post('/add', [SkillController::class, 'addSkills'])->middleware('auth:api');
});
Route::get('/skill/suggested', [SkillController::class, 'suggested']);
Route::get('/skill/search', [SkillController::class, 'search']);
Route::prefix('portfolios')->middleware('auth:api')->group(function () {
    Route::get('', [PortfolioController::class, 'index']);
    Route::post('', [PortfolioController::class, 'store']);
    Route::get('/{id}', [PortfolioController::class, 'show']);
    Route::post('/{id}', [PortfolioController::class, 'update']);
    Route::delete('/{portfolio}', [PortfolioController::class, 'destroy']);
});
Route::post('/language', [PortfolioController::class, 'addLanguage']);
