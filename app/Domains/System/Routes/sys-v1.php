<?php

use App\Domains\System\Controllers\Sys\V1\GeoConfigurationController;
use Illuminate\Routing\Route;

Route::post('geo/check-location', [GeoConfigurationController::class, 'checkLocation']);
Route::post('geo/emergency-lock', [GeoConfigurationController::class, 'emergencyGeoLock'])->middleware('version.capture');

Route::post('rate-limits/emergency', [GeoConfigurationController::class, 'emergencyThrottling'])->middleware('version.capture');

Route::post('config-versioning/manual-snapshot',
    [GeoConfigurationController::class, 'createManualSnapshot']);

Route::post('config-versioning/{snapshot}/rollback', [GeoConfigurationController::class, 'rollback']);
