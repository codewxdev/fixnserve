<?php

use App\Domains\Audit\Controllers\Cp\V1\AuditAdminController;
use App\Domains\Audit\Controllers\Cp\V1\FinancialAuditController;
use App\Domains\Audit\Controllers\Cp\V1\SecurityAuditController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
    Route::middleware('auth:api', 'user.active', 'active.session', 'validate.session', 'role:Super Admin')->group(function () {
        Route::get('/admin-actions', [AuditAdminController::class, 'adminAudit']);
        Route::get('/permission-audit', [AuditAdminController::class, 'permissionAudit']);
        Route::get('/security-audit/overview', [AuditAdminController::class, 'overview']);
        Route::get('/security-audit', [AuditAdminController::class, 'securityAudit']);

        Route::prefix('financial-audit')->group(function () {
            // ✅ Dashboard
            Route::get('/dashboard', [FinancialAuditController::class, 'dashboard']);

            // ✅ Ledger
            Route::get('/ledger', [FinancialAuditController::class, 'ledger']);
            Route::post('/ledger', [FinancialAuditController::class, 'postManualEntry']);
            Route::get('/ledger/{ledger}', [FinancialAuditController::class, 'showLedger']);
            Route::get('/ledger/{ledger}/verify', [FinancialAuditController::class, 'verifyIntegrity']);
            Route::get('/export', [FinancialAuditController::class, 'exportLedger']);

            // ✅ Reconciliation
            Route::post('/snapshots', [FinancialAuditController::class, 'generateSnapshot']);
            Route::get('/snapshots', [FinancialAuditController::class, 'snapshots']);
            Route::patch('/snapshots/{snapshot}', [FinancialAuditController::class, 'reviewSnapshot']);

            // ✅ COD
            Route::get('/cod', [FinancialAuditController::class, 'codReconciliation']);
            Route::patch('/cod/{cod}/deposit', [FinancialAuditController::class, 'markCodDeposited']);

            // ✅ Commission
            Route::get('/commissions', [FinancialAuditController::class, 'commissions']);

            // ✅ Audit Flags
            Route::get('/flags', [FinancialAuditController::class, 'auditFlags']);
            Route::patch('/flags/{flag}/resolve', [FinancialAuditController::class, 'resolveFlag']);

            // ✅ Entity Statement
            Route::get('/statement/{entityType}/{entityId}', [FinancialAuditController::class, 'entityStatement']);
        });
        Route::prefix('security-audit')->group(function () {
            // ✅ Overview
            Route::get('/dashboard', [SecurityAuditController::class, 'dashboard']);
            // ✅ Audit Logs
            Route::get('/logs', [SecurityAuditController::class, 'auditLogs']);
            Route::get('/logs/{log}', [SecurityAuditController::class, 'showLog']);
            Route::get('/logs/user/{userId}', [SecurityAuditController::class, 'userTimeline']);
            Route::get('/logs/ip/{ip}', [SecurityAuditController::class, 'ipActivity']);
            Route::get('/export', [SecurityAuditController::class, 'exportLogs']);
            // ✅ Anomalies
            Route::get('/anomalies', [SecurityAuditController::class, 'anomalies']);
            Route::post('/anomalies/{anomaly}/investigate', [SecurityAuditController::class, 'investigateAnomaly']);
            Route::post('/anomalies/{anomaly}/resolve', [SecurityAuditController::class, 'resolveAnomaly']);
            // ✅ Privilege & Policy
            Route::get('/privilege-logs', [SecurityAuditController::class, 'privilegeLogs']);
            Route::get('/policy-changes', [SecurityAuditController::class, 'policyChanges']);
            // ✅ Reports
            Route::get('/reports/failed-logins', [SecurityAuditController::class, 'failedLoginReport']);
        });

    });
});
