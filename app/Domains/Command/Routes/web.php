<?php

use App\Domains\Command\Controllers\Front\MaintenanceController;
use App\Domains\Command\Controllers\Front\PlatformOverviewController;
use App\Domains\Command\Controllers\Front\RegionalController;
use App\Domains\Command\Controllers\Front\SystemHealthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 1: COMMAND CENTER)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',                  
    'auth.admin',           
    // 'admin.mfa',            // P0 Spec: MFA mandatory for admin panel
    'admin.ip_whitelist',   // P0 Spec: IP whitelist on admin panel
    // 'admin.device_trust',   // P1 Spec: Device trust for admin
             
])
->prefix('cp-x9f7a2/v1')     
->name('cp.')                
->group(function () {

    // ========================================================
    // SUB-MODULE 1.1: EXECUTIVE DASHBOARD
    // ========================================================
    Route::get('/dashboard', [PlatformOverviewController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/export', [PlatformOverviewController::class, 'export'])->name('dashboard.export');

    // ========================================================
    // SUB-MODULE 1.2: SYSTEM HEALTH
    // ========================================================
    Route::get('/system-health', [SystemHealthController::class, 'index'])->name('system-health.index');
    Route::post('/system-health/queues/{queue}/throttle', [SystemHealthController::class, 'throttleQueue'])->name('system-health.queue.throttle');
    Route::post('/system-health/queues/{queue}/replay-dlq', [SystemHealthController::class, 'replayDeadLetterQueue'])->name('system-health.queue.replay');

    // ========================================================
    // SUB-MODULE 1.3: REGIONAL CONTROL
    // ========================================================
    Route::get('/regional-control', [RegionalController::class, 'index'])->name('regional.index');
     Route::patch('/regional-control/regions/{id}/status', [RegionalController::class, 'updateStatus'])->name('regional.update-status');

    // ========================================================
    // SUB-MODULE 1.4: MAINTENANCE & EMERGENCY
    // ========================================================
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::post('/maintenance/schedule', [MaintenanceController::class, 'schedule'])->name('maintenance.schedule');
    
     Route::post('/maintenance/kill-switch', [MaintenanceController::class, 'executeKillSwitch'])->name('maintenance.kill-switch');
    
     Route::post('/maintenance/override/activate', [MaintenanceController::class, 'activateOverride'])->name('maintenance.override.activate');
    Route::post('/maintenance/override/terminate', [MaintenanceController::class, 'terminateOverride'])->name('maintenance.override.terminate');

});