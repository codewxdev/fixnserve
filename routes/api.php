<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetCodeController;
use App\Http\Controllers\Consultancy\ConsultancyProfileController;
use App\Http\Controllers\Consultancy\ConsultantWeekDayController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\MartVender\BusinessDocController;
use App\Http\Controllers\MartVender\MartCategoryController;
use App\Http\Controllers\MartVender\MartSubCategoryController;
use App\Http\Controllers\MartVender\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PromotionPurchaseController;
use App\Http\Controllers\PromotionSlotController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RiderVehicleController;
use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\Role\UserRoleController;
use App\Http\Controllers\ServiceProvider\CategoryController;
use App\Http\Controllers\ServiceProvider\NotificationTypeController;
use App\Http\Controllers\ServiceProvider\PortfolioController;
use App\Http\Controllers\ServiceProvider\ServiceController;
use App\Http\Controllers\ServiceProvider\ServiceProviderController;
use App\Http\Controllers\ServiceProvider\SkillController;
use App\Http\Controllers\ServiceProvider\SubcategoryController;
use App\Http\Controllers\ServiceProvider\UserEducationController;
use App\Http\Controllers\ServiceProvider\UserExperienceController;
use App\Http\Controllers\ServiceProvider\UserNotificationController;
use App\Http\Controllers\ServiceProvider\UserPaymentController;
use App\Http\Controllers\ServiceProvider\UserTransportationController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionEntitlementController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\SubSpecialtyController;
use App\Http\Controllers\TransportTypeController;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Route;




// Public Routes (No authentication required)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('/password/forgot', [PasswordResetCodeController::class, 'sendResetCode']);
Route::post('/password/verify-code', [PasswordResetCodeController::class, 'verifyCode']);
Route::post('/password/reset', [PasswordResetCodeController::class, 'resetPassword']);
Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);
Route::get('/skill/suggested', [SkillController::class, 'suggested']);
Route::get('/skill/search', [SkillController::class, 'search']);
Route::apiResource('notification-types', NotificationTypeController::class);
Route::resource('mart-categories', MartCategoryController::class);
Route::apiResource('mart-sub-categories', MartSubCategoryController::class);
// routes/api.php
Route::apiResource('specialties', SpecialtyController::class);
Route::apiResource('sub-specialties', SubSpecialtyController::class);

Route::get('/countries', function () {
    return response()->json([
        'success' => true,
        'data' => Country::orderBy('name')->get(),
    ]);
});
Route::get('/currences', function () {
    return response()->json([
        'success' => true,
        'data' => Currency::orderBy('name')->get(),
    ]);
});
// Main Authenticated Routes Group with User Status Check
Route::middleware(['auth:api', 'user.active'])->group(function () {
    // Auth Routes
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    Route::post('/2fa/enable', [AuthController::class, 'enable2FA']);
    Route::post('/update/profile/{id}', [AuthController::class, 'updateProfile']);
    Route::post('/favorite/toggle', [FavouriteController::class, 'toggleFavorite']);
    Route::get('/favorite/list', [FavouriteController::class, 'listFavorites']);
    Route::post('/rate', [RatingController::class, 'rate']);
    ////////////////////////////////////Rider Module//////////////////////////////////////////

    Route::post('/rider/vehicles', [RiderVehicleController::class, 'store']);
    Route::post('/orders', [OrderController::class, 'store']);

    // ///////////////////////////////mart vender routes//////////////////////////////////////
    Route::apiResource('products', ProductController::class);
    Route::post('/products/{id}', [ProductController::class, 'update']);
    Route::post('/product/import', [ProductController::class, 'import']);
    Route::prefix('business-docs')->group(function () {
        Route::get('/', [BusinessDocController::class, 'index']);
        Route::post('/', [BusinessDocController::class, 'store']);
        Route::get('/{id}', [BusinessDocController::class, 'show']);
        Route::post('/{id}', [BusinessDocController::class, 'update']);
        Route::delete('/{id}', [BusinessDocController::class, 'destroy']);

        // Admin verification
        Route::post('/{id}/verify', [BusinessDocController::class, 'verify']);
    });
    // /////////////////////////////consultancy routes/////////////////////////////////////////
    Route::get('/consultant/profile', [ConsultancyProfileController::class, 'show']);
    Route::post('/consultant/profile', [ConsultancyProfileController::class, 'storeOrUpdate']);
    // Week Days (Mon–Sun toggle)
    Route::get('/consultant/week-days', [ConsultantWeekDayController::class, 'index']);
    Route::post('/consultant/week-days', [ConsultantWeekDayController::class, 'store']);
    Route::put('/consultant/day-availabilities', [ConsultantWeekDayController::class, 'update']);
    Route::delete('/consultant/week-days/{id}', [ConsultantWeekDayController::class, 'destroy']);
    // Route::middleware(['service.provider'])->group(function () {
    Route::post('/language', [PortfolioController::class, 'addLanguage']);
    Route::post('/phone/verify', [AuthController::class, 'verifyPhoneOtp']);
    // Service Provider Routes
    Route::prefix('service-provider')->group(function () {
        Route::apiResource('services', ServiceController::class);
        Route::post('/categories-subcategories', [ServiceProviderController::class, 'saveCategoriesAndSubcategories']);
        Route::post('/update/account', [ServiceProviderController::class, 'updateAccount']);
        Route::post('/update/mode', [ServiceProviderController::class, 'updateMode']);
    });
    // Skills Routes
    Route::prefix('skills')->group(function () {
        Route::post('/add', [SkillController::class, 'addSkills']);
    });
    // Portfolio Routes
    Route::prefix('portfolios')->group(function () {
        Route::apiResource('portfolios', PortfolioController::class);
    });
    // Education & Certificates Routes
    Route::prefix('education')->group(function () {
        Route::get('/', [UserEducationController::class, 'getProfile']);
        Route::post('/', [UserEducationController::class, 'storeProfile']);
        Route::post('/{id}', [UserEducationController::class, 'updateEducation']);
        Route::delete('{id}', [UserEducationController::class, 'deleteEducation']);
    });
    Route::prefix('certificates')->group(function () {
        Route::post('/upload', [UserEducationController::class, 'uploadCertificates']);
        Route::delete('/{id}', [UserEducationController::class, 'deleteCertificate']);
        Route::get('/download/{id}', [UserEducationController::class, 'downloadCertificate']);
    });
    // Payment Routes
    Route::prefix('payments')->group(function () {
        Route::get('/', [UserPaymentController::class, 'index']);
        Route::post('/', [UserPaymentController::class, 'store']);
        Route::post('/{id}/set-default', [UserPaymentController::class, 'setDefault']);
        Route::delete('/{id}', [UserPaymentController::class, 'destroy']);
        Route::get('/type/{type}', [UserPaymentController::class, 'byType']);
    });
    // Notification Routes
    Route::prefix('notifications')->group(function () {
        // Get all settings for logged-in user
        Route::get('/settings', [UserNotificationController::class, 'getUserNotificationSettings']);
        // Update settings for a specific type
        Route::post('/settings/update', [UserNotificationController::class, 'updateNotificationSettings']);
        // Reset to defaults
        Route::post('/settings/reset', [UserNotificationController::class, 'resetToDefaults']);

    });
    Route::prefix('transportations')->group(function () {
        // Get transportation settings
        Route::get('/', [UserTransportationController::class, 'getTransportations']);
        // Update transportation settings
        Route::post('/', [UserTransportationController::class, 'updateTransportations']);
    });
    // });
    Route::prefix('experiences')->group(function () {
        Route::get('/', [UserExperienceController::class, 'index']);
        Route::post('/', [UserExperienceController::class, 'store']);
        Route::get('/{id}', [UserExperienceController::class, 'show']);
        Route::put('/{id}', [UserExperienceController::class, 'update']);
        Route::delete('/{id}', [UserExperienceController::class, 'destroy']);
    });
    // Super Admin Routes (with additional checks)
    Route::middleware(['role:Super Admin', '2fa'])->group(function () {
        // Route::apiResource('roles', RoleController::class);
        // Route::apiResource('permissions', PermissionController::class);
        // Route::post('/role-permission', [RolePermissionController::class, 'assignPermission']);
        Route::delete('/role-permission', [RolePermissionController::class, 'removePermission']);
        Route::get('/role-permission/{role}', [RolePermissionController::class, 'getPermissions']);
        Route::prefix('users')->group(function () {
            // Route::post('/assign-role', [UserRoleController::class, 'assignRole']);
            // Route::post('/assign-permissions', [UserRoleController::class, 'assignPermissionsToUser']);
            Route::get('/{id}/roles', [UserRoleController::class, 'getUserRoles']);
            Route::get('/{id}/permissions', [UserRoleController::class, 'getUserPermissions']);
        });
        Route::get('/login-history', [AuthController::class, 'loginHistory']);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('subcategories', SubcategoryController::class);
        Route::apiResource('skills', SkillController::class);
        Route::put('/updateStatus', [ServiceController::class, 'updateStatus']);
    });
});
Route::middleware(['auth:api'])->prefix('admin')->group(function () {
    Route::apiResource('subscription-plans', SubscriptionPlanController::class);
    Route::apiResource('subscription-entitlements', SubscriptionEntitlementController::class);
    Route::apiResource('promotions', PromotionController::class);
    Route::apiResource('promotion-slots', PromotionSlotController::class);
    Route::post('/trasportation/type',[TransportTypeController::class, 'store']);
});
Route::middleware('auth:api')->group(function () {

    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::post('/unsubscribe', [SubscriptionController::class, 'cancel']);
    Route::get('/subscription/status', [SubscriptionController::class, 'status']);
    Route::get('/subscription/entitlements', [SubscriptionController::class, 'entitlements']);
    Route::post('/promotion-purchases', [PromotionPurchaseController::class, 'store']);

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

Route::apiResource('roles', RoleController::class);
Route::apiResource('permissions', PermissionController::class);
Route::post('/assign-role', [UserRoleController::class, 'assignRole']);
Route::post('/assign-permissions', [UserRoleController::class, 'assignPermissionsToUser']);
