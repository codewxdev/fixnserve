<?php

use App\Domains\Config\Controllers\Front\SystemConfigurationController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'auth.admin',
    // 'admin.mfa',
    // 'audit_logger'
])
->prefix('cp-x9f7a2/v1/system-configuration')
->name('cp.configuration.')
->group(function () {
    
    Route::get('/global', [SystemConfigurationController::class, 'globalSettings'])->name('global');
    Route::get('/feature-flags', [SystemConfigurationController::class, 'featureFlags'])->name('flags');
    Route::get('/environment', [SystemConfigurationController::class, 'environment'])->name('environment');
    Route::get('/localization', [SystemConfigurationController::class, 'localization'])->name('localization');
    Route::get('/geo', [SystemConfigurationController::class, 'geoConfig'])->name('geo');
    Route::get('/rate-limits', [SystemConfigurationController::class, 'rateLimits'])->name('rate_limits');
    Route::get('/versioning', [SystemConfigurationController::class, 'versioning'])->name('versioning');
    Route::get('/ai-impact', [SystemConfigurationController::class, 'aiImpact'])->name('ai_impact');

});