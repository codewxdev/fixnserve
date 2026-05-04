<?php

use App\Domains\Payments\Controllers\Front\PaymentInfrastructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 8: PAYMENT INFRASTRUCTURE
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
    ->prefix('cp-x9f7a2/v1/payments')
    ->name('cp.payments.')
    ->group(function () {

        Route::get('/connect', [PaymentInfrastructureController::class, 'connect'])->name('connect');
        Route::get('/monitoring', [PaymentInfrastructureController::class, 'monitoring'])->name('monitoring');
        Route::get('/webhooks', [PaymentInfrastructureController::class, 'webhooks'])->name('webhooks');
        Route::get('/keys', [PaymentInfrastructureController::class, 'keys'])->name('keys');
        Route::get('/fallbacks', [PaymentInfrastructureController::class, 'fallbacks'])->name('fallbacks');
        Route::get('/instant-payouts', [PaymentInfrastructureController::class, 'instant'])->name('instant');
    });
