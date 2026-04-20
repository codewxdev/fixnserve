<?php

use App\Domains\System\Controllers\Front\SystemController;
use Illuminate\Support\Facades\Route;


Route::prefix('/cp-x9f7/v1')->group(function () {
// System Settings Global Routes
Route::get('/system', [SystemController::class, 'index'])->name('settings.global');


// System Settings feature Routes
Route::get('/system/feature-control', [SystemController::class, 'featureControl'])->name('settings.feature_control'); 

// System Settings localization Routes
Route::get('/system/localization', [SystemController::class, 'localization'])->name('settings.localization'); 

// System Settings geo Routes
Route::get('/system/geo', [SystemController::class, 'geo'])->name('settings.geo');


// system rate & limit Routes
Route::get('/system/rate-limit', [SystemController::class, 'rateLimit'])->name('settings.rate_limit');

// sytem configuration versioning & rollback Routes
Route::get('/system/configuration-versioning', [SystemController::class, 'configurationVersioning'])->name('settings.configuration_versioning');

// system configuration impact analysis Routes
Route::get('/system/configuration-impact-analysis', [SystemController::class, 'configurationImpactAnalysis'])->name('settings.configuration_impact_analysis');

// system access control & governance Routes
Route::get('/system/access-control', [SystemController::class, 'accessControl'])->name('settings.access_control');


});