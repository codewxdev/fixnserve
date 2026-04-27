<?php

use App\Domains\Accounts\Controllers\Front\BusinessController;
use App\Domains\Accounts\Controllers\Front\BusinessLifecycleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 4: BUSINESS ACCOUNTS)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web', 'auth.admin', 'admin.ip_whitelist',
])
->prefix('cp-x9f7a2/v1/businesses')
->name('cp.businesses.')
->group(function () {

    // Unified Business Directory (Agencies, Consultants, Home Services, etc.)
    // Route::get('/directory', [BusinessController::class, 'index'])->name('index');
    // Route::post('/directory', [BusinessController::class, 'store'])->name('store');
    // Route::put('/directory/{id}', [BusinessController::class, 'update'])->name('update');
    // Route::delete('/directory/{id}', [BusinessController::class, 'destroy'])->name('destroy');

    // Business Lifecycle & State Management (Active, Suspended, Pending)
    // Route::get('/lifecycle', [BusinessLifecycleController::class, 'index'])->name('lifecycle');
    // Route::post('/lifecycle/{id}/suspend', [BusinessLifecycleController::class, 'suspend'])->name('suspend');

});
