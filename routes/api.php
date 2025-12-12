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
use App\Http\Controllers\ServiceProvider\UserEducationController;
use App\Http\Controllers\ServiceProvider\UserNotificationController;
use App\Http\Controllers\ServiceProvider\UserPaymentController;
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
Route::get('/skill/suggested', [SkillController::class, 'suggested']);
Route::get('/skill/search', [SkillController::class, 'search']);

Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

});
Route::middleware(['auth:api', 'role:Super Admin', '2fa'])->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
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
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('subcategories', SubcategoryController::class);
    Route::apiResource('skills', SkillController::class);
    // / Update Service Status
    Route::put('/updateStatus', [ServiceController::class, 'updateStatus']);
});
Route::prefix('service-provider')->middleware('auth:api')->group(function () {
    Route::apiResource('services', ServiceController::class);
    Route::post('/categories-subcategories', [ServiceProviderController::class, 'saveCategoriesAndSubcategories']);
});
Route::prefix('skills')->group(function () {
    Route::post('/add', [SkillController::class, 'addSkills'])->middleware('auth:api');
});
Route::prefix('portfolios')->middleware('auth:api')->group(function () {
    Route::apiResource('portfolios', PortfolioController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::post('/language', [PortfolioController::class, 'addLanguage']);
    // Get complete profile (educations + certificates)
    Route::get('/education', [UserEducationController::class, 'getProfile']);
    // Store education with optional certificates
    Route::post('/education', [UserEducationController::class, 'storeProfile']);
    // Education CRUD
    Route::post('/education/{id}', [UserEducationController::class, 'updateEducation']);
    Route::delete('/education/{id}', [UserEducationController::class, 'deleteEducation']);
    // Certificates operations
    Route::post('/certificates/upload', [UserEducationController::class, 'uploadCertificates']);
    Route::delete('/certificates/{id}', [UserEducationController::class, 'deleteCertificate']);
    Route::get('/certificates/download/{id}', [UserEducationController::class, 'downloadCertificate']);
});
Route::middleware(['auth:api'])->prefix('payments')->group(function () {
    // Get all payment methods
    Route::get('/', [UserPaymentController::class, 'index']);
    // Add new payment method
    Route::post('/', [UserPaymentController::class, 'store']);
    // Set as default
    Route::post('/{id}/set-default', [UserPaymentController::class, 'setDefault']);
    // Delete payment method
    Route::delete('/{id}', [UserPaymentController::class, 'destroy']);
    // Get by type
    Route::get('/type/{type}', [UserPaymentController::class, 'byType']);
});

Route::middleware(['auth:api'])->prefix('notifications')->group(function () {
    // Get notification settings
    Route::get('/', [UserNotificationController::class, 'getSettings']);

    // Set all notifications at once
    Route::post('/set-all', [UserNotificationController::class, 'setNotificationSettings']);
});

// /////////////////////////////////////////extra code//////////////////////////////////////

// Route::get('/roles/{role?}', [RoleController::class, 'index']);
// Route::post('/roles', [RoleController::class, 'store']);
// Route::post('/roles/{role}', [RoleController::class, 'update']);
// Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
// Permissions CRUD
// Route::get('/permissions/{permission?}', [PermissionController::class, 'index']);
// Route::post('/permissions', [PermissionController::class, 'store']);
// Route::post('/permissions/{permission}', [PermissionController::class, 'update']);
// Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy']);

// -------------------------
// CATEGORY CRUD
// -------------------------
// Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories', [CategoryController::class, 'store']);
// Route::get('/categories/{id}', [CategoryController::class, 'show']);
// Route::put('/categories/{id}', [CategoryController::class, 'update']);
// Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// -------------------------
// SUBCATEGORY CRUD
// -------------------------
// Route::get('/subcategories', [SubcategoryController::class, 'index']);
// Route::post('/subcategories', [SubcategoryController::class, 'store']);
// Route::get('/subcategories/{id}', [SubcategoryController::class, 'show']);
// Route::post('/subcategories/{id}', [SubcategoryController::class, 'update']);
// Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy']);

// -------------------------
// SKILL CRUD
// -------------------------
// Route::get('/skills', [SkillController::class, 'index']);
// Route::post('/skills', [SkillController::class, 'store']);
// Route::get('/skills/{id}', [SkillController::class, 'show']);
// Route::put('/skills/{id}', [SkillController::class, 'update']);
// Route::delete('/skills/{id}', [SkillController::class, 'destroy']);
// SERVICE CRUD
// -------------------------

// Route::get('/services', [ServiceController::class, 'index']);
// Route::post('/services', [ServiceController::class, 'store']);
// Route::get('/services/{id}', [ServiceController::class, 'show']);
// Route::put('/services/{id}', [ServiceController::class, 'update']);
// Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
// Route::get('', [PortfolioController::class, 'index']);
// Route::post('', [PortfolioController::class, 'store']);
// Route::get('/{id}', [PortfolioController::class, 'show']);
// Route::post('/{id}', [PortfolioController::class, 'update']);
// Route::delete('/{portfolio}', [PortfolioController::class, 'destroy']);
