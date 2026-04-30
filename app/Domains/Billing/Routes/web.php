<?php

use App\Domains\Billing\Controllers\Front\BillingController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'auth.admin',
    // 'admin.mfa',
    // 'audit_logger'
])
->prefix('cp-x9f7a2/v1/billing')
->name('cp.billing.')
->group(function () {
    
    Route::get('/plans', [BillingController::class, 'plans'])->name('plans');
    Route::get('/entitlements', [BillingController::class, 'entitlements'])->name('entitlements');
    Route::get('/lifecycle', [BillingController::class, 'lifecycle'])->name('lifecycle');
    Route::get('/enforcement', [BillingController::class, 'enforcement'])->name('enforcement');
    Route::get('/overrides', [BillingController::class, 'overrides'])->name('overrides');

});