<?php

use App\Domains\Finance\Controllers\Front\FinanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 7: FINANCE & PLATFORM REVENUE)
|--------------------------------------------------------------------------
| Single financial source of truth. Handles immutable ledgers, wallets,
| commissions, payouts, and compliance.
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    'auth.admin',
    // 'admin.mfa',
    // 'admin.ip_whitelist',
    // 'audit_logger' // Strict requirement for financial operations
])
->prefix('cp-x9f7a2/v1/finance')
->name('cp.finance.')
->group(function () {
    
    Route::get('/ledger', [FinanceController::class, 'ledger'])->name('ledger');
    Route::get('/wallets', [FinanceController::class, 'wallets'])->name('wallets');
    Route::get('/commissions', [FinanceController::class, 'commissions'])->name('commissions');
    Route::get('/payouts', [FinanceController::class, 'payouts'])->name('payouts');
    Route::get('/refunds', [FinanceController::class, 'refunds'])->name('refunds');

});