<?php

use App\Domains\Fraud\Controllers\Front\FraudController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 9: FRAUD & RISK)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web', 'auth.admin', 'admin.mfa', 'admin.ip_whitelist', 'admin.device_trust'
])
->prefix('cp-x9f7a2/v1/fraud-risk')
->name('cp.fraud-risk.')
->group(function () {

    // Risk Scoring Engine
    Route::get('/scoring', [FraudController::class, 'index'])->name('scoring');

    // Session & Identity Risk
    Route::get('/identity', [FraudController::class, 'SessionIdentityRisk'])->name('identity');

    // Payment & Transaction Fraud
    Route::get('/payments', [FraudController::class, 'PaymentWallet'])->name('payments');

    // Automated Enforcement
    Route::get('/enforcement', [FraudController::class, 'AutomatedEnforcementEngine'])->name('enforcement');

    // Collusion & Abuse
    Route::get('/abuse', [FraudController::class, 'PromotionIncentiveAbuse'])->name('abuse');
    Route::get('/collusion', [FraudController::class, 'CollusionNetworks'])->name('collusion');

    // Manual Overrides & Governance
    Route::get('/overrides', [FraudController::class, 'ManualOverridesGovernance'])->name('overrides');

});