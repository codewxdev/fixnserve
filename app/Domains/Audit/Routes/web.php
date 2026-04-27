<?php

use App\Domains\Audit\Controllers\Front\AuditController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 13: AUDIT & COMPLIANCE)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web', 'auth.admin', 'admin.mfa', 'admin.ip_whitelist', 'admin.device_trust'
])
->prefix('cp-x9f7a2/v1/audit-logs')
->name('cp.audit-logs.')
->group(function () {

    // Admin Action Audit Logs
    Route::get('/actions', [AuditController::class, 'index'])->name('actions');

    // Financial & Transaction Audit
    Route::get('/financial', [AuditController::class, 'financialTransactionAudit'])->name('financial');

    // Security & Access Audit
    Route::get('/security', [AuditController::class, 'securityAccessAudit'])->name('security');

    // Data Access & Privacy Compliance (GDPR/UAE Law)
    Route::get('/privacy', [AuditController::class, 'dataAccessPrivacyCompliance'])->name('privacy');

    // Regulatory Reporting & Exports
    Route::get('/exports', [AuditController::class, 'regulatoryReportingExports'])->name('exports');

    // Data Retention & Legal Holds
    Route::get('/retention', [AuditController::class, 'dataRetentionLegalHolds'])->name('retention');

    // Audit Search, Replay & Forensics
    Route::get('/forensics', [AuditController::class, 'auditSearchReplayForensics'])->name('forensics');

    // Compliance Monitoring & Alerts
    Route::get('/monitoring', [AuditController::class, 'complianceMonitoringAlerts'])->name('monitoring');

});
