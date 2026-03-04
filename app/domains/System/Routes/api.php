<?php

use App\Domains\System\Controllers\Api\FeatureFlagController;
use App\Domains\System\Controllers\Api\PlatformPreferenceController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {
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

    });
});
