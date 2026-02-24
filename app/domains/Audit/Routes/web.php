<?php

use App\Domains\Audit\Controllers\AuditController;
use Illuminate\Support\Facades\Route;
 
// admin action audit Routes
Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');

// financial transaction audit Routes
Route::get('/audit/financial-transaction', [AuditController::class, 'financialTransactionAudit'])->name('audit.financial_transaction');

// security access audit Routes
Route::get('/audit/security-access', [AuditController::class, 'securityAccessAudit'])->name('audit.security_access');


// data access privacy compliance Routes
Route::get('/audit/data-access-privacy-compliance', [AuditController::class, 'dataAccessPrivacyCompliance'])->name('audit.data_access_privacy_compliance');


// regulatory reporting & exports Routes
Route::get('/audit/regulatory-reporting-exports', [AuditController::class, 'regulatoryReportingExports'])->name('audit.regulatory_reporting_exports');


// data retention & legal holds Routes
Route::get('/audit/data-retention-legal-holds', [AuditController::class, 'dataRetentionLegalHolds'])->name('audit.data_retention_legal_holds');