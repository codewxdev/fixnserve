<?php

use App\Domains\Command\Controllers\Front\MaintenanceController;
use App\Domains\Command\Controllers\Front\PlatformOverviewController;
use App\Domains\Command\Controllers\Front\RegionalController;
use App\Domains\Command\Controllers\Front\SystemHealthController;
use Illuminate\Support\Facades\Route;
 

Route::middleware([
    'web',                  // Standard Laravel web stack (CSRF, Cookies)
    'auth.admin',           // Authenticated admin session
    // 'admin.mfa',            // RequireMFA Middleware
    'admin.ip_whitelist',   // VerifyIpWhitelist Middleware
    // 'admin.device_trust',   // RequireDeviceTrust Middleware
])
->prefix('cp-x9f7a2/v1')     
->name('cp.')                
->group(function () {

    // 1.1 Executive Dashboard
    Route::get('/dashboard', [PlatformOverviewController::class, 'index'])
        ->name('dashboard');

    // 1.2 System Health
    Route::get('/system-health', [SystemHealthController::class, 'index'])
        ->name('system-health.index');

    // 1.3 Regional Control
    Route::get('/regional-control', [RegionalController::class, 'index'])
        ->name('regional.index');
        
    
    Route::patch('/regional-control/countries/{id}', [RegionalController::class, 'updateStatus'])
        ->name('regional.update-status');

    // 1.4 Maintenance & Emergency
    Route::get('/maintenance', [MaintenanceController::class, 'index'])
        ->name('maintenance.index');

});