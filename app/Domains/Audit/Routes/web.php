<?php

use App\Domains\Audit\Controllers\Front\AuditComplianceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 13: AUDIT, COMPLIANCE & REGULATORY
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/compliance')
->name('cp.audit.')
->group(function () {
    
    Route::get('/admin-actions', [AuditComplianceController::class, 'actions'])->name('actions');
    Route::get('/financial', [AuditComplianceController::class, 'financial'])->name('financial');
    Route::get('/security', [AuditComplianceController::class, 'security'])->name('security');
    Route::get('/data-access', [AuditComplianceController::class, 'access'])->name('access');
    Route::get('/reporting', [AuditComplianceController::class, 'reporting'])->name('reporting');
    Route::get('/retention', [AuditComplianceController::class, 'retention'])->name('retention');
    Route::get('/forensics', [AuditComplianceController::class, 'forensics'])->name('forensics');

});