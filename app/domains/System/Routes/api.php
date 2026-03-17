<?php

use App\Domains\System\Controllers\Api\CountryController;
use App\Domains\System\Controllers\Api\DualApprovalRuleController;
use App\Domains\System\Controllers\Api\FeatureFlagController;
use App\Domains\System\Controllers\Api\GeoConfigurationController;
use App\Domains\System\Controllers\Api\PlatformPreferenceController;
use App\Domains\System\Controllers\Api\RateLimitController;
use App\Domains\System\Controllers\Api\ReasonCodeController;
use App\Domains\System\Controllers\Api\TimeBoundPrivilegeController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
    Route::middleware(['auth:api', 'role:Super Admin', '2fa', 'user.active', 'active.session'])->group(function () {
        Route::prefix('admin/platform-preferences')->group(function () {
            Route::post('/update', [PlatformPreferenceController::class, 'update']);
            Route::get('/current', [PlatformPreferenceController::class, 'current']);
        });
        Route::prefix('admin/feature-flags')->group(function () {
            Route::get('/', [FeatureFlagController::class, 'index']);
            Route::post('/', [FeatureFlagController::class, 'store']);
            Route::put('/{flag}', [FeatureFlagController::class, 'update']);
            Route::delete('/{flag}', [FeatureFlagController::class, 'destroy']);
        });

        Route::prefix('geo')->group(function () {

            // Core Settings
            Route::get('/config', [GeoConfigurationController::class, 'getCoreSettings']);
            Route::post('/config', [GeoConfigurationController::class, 'saveCoreSettings']);

            // Geofences
            Route::get('/geofences', [GeoConfigurationController::class, 'getGeofences']);
            Route::post('/geofences', [GeoConfigurationController::class, 'addGeofence'])->middleware('reason.code');
            Route::put('/geofences/{geofence}', [GeoConfigurationController::class, 'updateGeofence']);
            Route::delete('/geofences/{geofence}', [GeoConfigurationController::class, 'deleteGeofence']);
            Route::patch('/geofences/{geofence}/toggle', [GeoConfigurationController::class, 'toggleGeofence']);

            // Emergency
            Route::post('/emergency-lock', [GeoConfigurationController::class, 'emergencyGeoLock']);

            // Check location
            Route::post('/check-location', [GeoConfigurationController::class, 'checkLocation']);
        });
        // routes/api.php
        Route::prefix('rate-limits')->group(function () {

            // ✅ Get & Save limits
            Route::get('/', [RateLimitController::class, 'getConfig']);
            Route::post('/save', [RateLimitController::class, 'saveLimits'])->middleware('reason.code');

            // ✅ Emergency
            Route::post('/emergency', [RateLimitController::class, 'emergencyThrottling']);

            // ✅ Overrides
            Route::get('/overrides', [RateLimitController::class, 'getOverrides']);
            Route::post('/overrides', [RateLimitController::class, 'addOverride']);
            Route::delete('/overrides/{override}', [RateLimitController::class, 'deleteOverride']);
        });

        Route::prefix('access-control/grants')
            ->group(function () {
                Route::get('/', [TimeBoundPrivilegeController::class, 'index']);   // Active grants
                Route::post('/', [TimeBoundPrivilegeController::class, 'store'])->middleware('reason.code');   // Grant privilege
                Route::delete('/{privilege}', [TimeBoundPrivilegeController::class, 'revoke']); // Revoke
                Route::get('/history', [TimeBoundPrivilegeController::class, 'history']); // All history
            });
        Route::prefix('access-control/approval-rules')
            ->group(function () {
                Route::get('/', [DualApprovalRuleController::class, 'index']);  // Get all
                Route::patch('/{rule}/toggle', [DualApprovalRuleController::class, 'toggle']); // Toggle
            });
        Route::prefix('access-control/reason-codes')
            ->group(function () {
                Route::get('/', [ReasonCodeController::class, 'index']);
                Route::post('/', [ReasonCodeController::class, 'store']);
                Route::delete('/{reasonCode}', [ReasonCodeController::class, 'destroy']);
                Route::post('/policy', [ReasonCodeController::class, 'savePolicy']);
            });
    });

    Route::prefix('countries')->group(function () {

        Route::get('/list', [CountryController::class, 'index']);

        Route::patch('{iso2}/locale', [CountryController::class, 'updateLocale']);

        Route::patch('{iso2}/currency', [CountryController::class, 'updateCurrency']);

        Route::patch('{iso2}/formats', [CountryController::class, 'updateFormats']);

        Route::patch('{iso2}/enable-locale', [CountryController::class, 'enableLocale']);

        Route::patch('{iso2}/disable-locale', [CountryController::class, 'disableLocale']);

    });
});
