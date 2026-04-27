<?php

use App\Domains\System\Controllers\Front\SystemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 14: SYSTEM CONFIGURATION)
|--------------------------------------------------------------------------
 */

Route::middleware([
    'web', 
    'auth.admin', 
    // 'admin.mfa', 
    'admin.ip_whitelist', 
    // 'admin.device_trust'
])
->prefix('cp-x9f7a2/v1/configurations')
->name('cp.configurations.')
->group(function () {

    // Global Platform Settings
    Route::get('/global', [SystemController::class, 'index'])->name('global');

    // Feature Flags & Rollout Control
    Route::get('/feature-flags', [SystemController::class, 'featureControl'])->name('flags');

    // Localization & Internationalization
    Route::get('/localization', [SystemController::class, 'localization'])->name('localization');

    // Geo, Maps & Fencing Configuration
    Route::get('/geo', [SystemController::class, 'geo'])->name('geo');

    // Rate Limits & API Throttling
    Route::get('/rate-limits', [SystemController::class, 'rateLimit'])->name('rate_limit');

    // Configuration Versioning & Rollback
    Route::get('/versioning', [SystemController::class, 'configurationVersioning'])->name('versioning');

    // AI Impact Analysis (Predicting blast radius of config changes)
    Route::get('/impact-analysis', [SystemController::class, 'configurationImpactAnalysis'])->name('impact_analysis');

    // Module Access Control & Governance
    Route::get('/access-control', [SystemController::class, 'accessControl'])->name('access_control');

});