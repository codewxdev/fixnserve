<?php

use App\Domains\Accounts\Controllers\Front\BusinessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 4: BUSINESS ACCOUNTS)
|--------------------------------------------------------------------------
| Handles Business Registry, Lifecycle, and Intelligence operations.
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    'auth.admin',
    'admin.ip_whitelist',
    // 'admin.mfa',       // Recommended: Enforce MFA for administrative access
    // 'audit_logger'     // Recommended: Immutable audit logging
])
    ->prefix('cp-x9f7a2/v1/businesses')
    ->name('cp.businesses.')
    ->group(function () {

        // ========================================================
        // SUB-MODULE 4.1: BUSINESS REGISTRY
        // ========================================================
        // Main directory table, quick stats, and bulk actions
        Route::get('/', [BusinessController::class, 'index'])->name('index');

        // ========================================================
        // SUB-MODULE 4.2: BUSINESS LIFECYCLE
        // ========================================================
        // Dedicated view for lifecycle management and state transitions
        Route::get('/lifecycle-management', [BusinessController::class, 'lifecycle'])->name('lifecycle');
   
        // ========================================================
        // SUB-MODULE 4.3: BUSINESS INTELLIGENCE
        // ========================================================
        // Health scoring, risk analysis, and operations console
        Route::get('/intelligence', [BusinessController::class, 'intelligence'])->name('intelligence');

    });