<?php

use App\Domains\System\Controllers\Cp\V1\ConfigurationVersioningController;
use App\Domains\System\Controllers\Cp\V1\GeoConfigurationController;
use App\Domains\System\Controllers\Cp\V1\RateLimitController;
use Illuminate\Routing\Route;

Route::post('geo/check-location', [GeoConfigurationController::class, 'checkLocation']);
Route::post('geo/emergency-lock', [GeoConfigurationController::class, 'emergencyGeoLock'])->middleware('version.capture');

Route::post('rate-limits/emergency', [RateLimitController::class, 'emergencyThrottling'])->middleware('version.capture');

Route::post('config-versioning/manual-snapshot',
    [ConfigurationVersioningController::class, 'createManualSnapshot']);

Route::post('config-versioning/{snapshot}/rollback', [ConfigurationVersioningController::class, 'rollback']);
