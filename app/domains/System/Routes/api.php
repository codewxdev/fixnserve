<?php

use App\Domains\System\Controllers\Api\CountryController;
use App\Domains\System\Controllers\Api\FeatureFlagController;
use App\Domains\System\Controllers\Api\PlatformPreferenceController;
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
