<?php

use App\Http\Controllers\Consultancy\ConsultancyProfileController;
use App\Http\Controllers\Consultancy\ConsultantWeekDayController;
use App\Http\Controllers\ConsultantBookingController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\MartVender\BusinessDocController;
use App\Http\Controllers\MartVender\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PromotionPurchaseController;
use App\Http\Controllers\PromotionSlotController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RiderVehicleController;
use App\Http\Controllers\ServiceProvider\NotificationTypeController;
use App\Http\Controllers\ServiceProvider\PortfolioController;
use App\Http\Controllers\ServiceProvider\ServiceController;
use App\Http\Controllers\ServiceProvider\ServiceProviderController;
use App\Http\Controllers\ServiceProvider\UserEducationController;
use App\Http\Controllers\ServiceProvider\UserExperienceController;
use App\Http\Controllers\ServiceProvider\UserNotificationController;
use App\Http\Controllers\ServiceProvider\UserPaymentController;
use App\Http\Controllers\ServiceProvider\UserTransportationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionEntitlementController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\TransportTypeController;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {

    Route::apiResource('notification-types', NotificationTypeController::class);

    // ////////////////////////////////////consultant route/////////////////////
    Route::get('getSlot', [ConsultantBookingController::class, 'getSlots']);
    Route::get('/countries', function () {
        return response()->json([
            'success' => true,
            'data' => Country::orderBy('name')->get(),
        ]);
    });

    Route::get('/countries', function () {
        return Country::all();
    });

    Route::get('/currences', function () {
        return response()->json([
            'success' => true,
            'data' => Currency::orderBy('name')->get(),
        ]);
    });
    // Main Authenticated Routes Group with User Status Check
    Route::middleware(['auth:api', 'user.active', 'active.session'])->group(function () {
        // /////////middleware for blocking order for soft_disable country/////////
        Route::middleware(['block_soft_country_orders', 'check_maintenance:orders', 'kill:orders'])->group(function () {
            // //////////////////////////book slot for consultant////////////
            Route::post('bookSlot', [ConsultantBookingController::class, 'bookSlot']);
        });
        // ////////////////middleware for payment routes////////////////
        Route::middleware('kill:payments')->group(function () {});

        Route::post('/favorite/toggle', [FavouriteController::class, 'toggleFavorite']);
        Route::get('/favorite/list', [FavouriteController::class, 'listFavorites']);
        Route::post('/rate', [RatingController::class, 'rate']);
        // //////////////////////////////////Rider Module//////////////////////////////////////////
        Route::post('/rider/vehicles', [RiderVehicleController::class, 'store']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::post('/orders/{order}/accept', [OrderController::class, 'accept']);   // /////for rider request
        Route::post('/rider/location', [OrderController::class, 'update']);
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
        // Service Provider Routes
        Route::prefix('service-provider')->group(function () {
            Route::apiResource('services', ServiceController::class);
            Route::post('/categories-subcategories', [ServiceProviderController::class, 'saveCategoriesAndSubcategories']);
            Route::post('/update/account', [ServiceProviderController::class, 'updateAccount']);
            Route::post('/update/mode', [ServiceProviderController::class, 'updateMode']);
        });
        // Skills Routes

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
            Route::put('/updateStatus', [ServiceController::class, 'updateStatus']);
            // /////////////////////session managment//////////////////////////

        });

    });
    Route::middleware(['auth:api', 'active.session'])->prefix('admin')->group(function () {
        Route::apiResource('subscription-plans', SubscriptionPlanController::class);
        Route::apiResource('subscription-entitlements', SubscriptionEntitlementController::class);
        Route::apiResource('promotions', PromotionController::class);
        Route::apiResource('promotion-slots', PromotionSlotController::class);
        Route::post('/trasportation/type', [TransportTypeController::class, 'store']);
    });
    Route::middleware('auth:api', 'kill:subscriptions', 'active.session')->group(function () {

        Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
        Route::post('/unsubscribe', [SubscriptionController::class, 'cancel']);
        Route::get('/subscription/status', [SubscriptionController::class, 'status']);
        Route::get('/subscription/entitlements', [SubscriptionController::class, 'entitlements']);
        Route::post('/promotion-purchases', [PromotionPurchaseController::class, 'store']);

    });

});
