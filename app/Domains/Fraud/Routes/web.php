<?php

use App\Domains\Fraud\Controllers\Front\FraudController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 9: FRAUD, RISK & ABUSE
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/fraud-and-risk')
->name('cp.fraud.')
->group(function () {
    
    Route::get('/scoring', [FraudController::class, 'scoring'])->name('scoring');
    Route::get('/accounts', [FraudController::class, 'accounts'])->name('accounts');
    Route::get('/transactions', [FraudController::class, 'transactions'])->name('transactions');
    Route::get('/enforcement', [FraudController::class, 'enforcement'])->name('enforcement');
    Route::get('/overrides', [FraudController::class, 'overrides'])->name('overrides');

});