<?php

use App\Domains\Disputes\Controllers\Front\DisputeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 10: PLATFORM DISPUTES)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web', 'auth.admin', 'admin.mfa', 'admin.ip_whitelist', 'admin.device_trust'
])
->prefix('cp-x9f7a2/v1/disputes')
->name('cp.disputes.')
->group(function () {

    // Dispute Intake & Workflow
    Route::get('/workflow', [DisputeController::class, 'index'])->name('workflow');

    // Evidence & Context Management
    Route::get('/evidence', [DisputeController::class, 'EvidenceContext'])->name('evidence');

 });