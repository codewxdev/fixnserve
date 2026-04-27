<?php

use App\Domains\KYC\Controllers\Front\KycController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 5: BUSINESS KYC)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web', 'auth.admin', 'admin.ip_whitelist',
])
->prefix('cp-x9f7a2/v1/kyc')
->name('cp.kyc.')
->group(function () {

    // Verification Queue (Manual Review for Pilot)
    Route::get('/document-management', [KycController::class, 'index'])->name('document_management');

    // Document Repository
    Route::get('/verification', [KycController::class, 'verification'])->name('verification');

     

    // Compliance Governance
    Route::get('/governance', [KycController::class, 'ComplianceGovernance'])->name('governance');

});