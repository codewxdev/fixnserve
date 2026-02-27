<?php

use App\Domains\Audit\Controllers\Api\AuditAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {
    Route::middleware('auth:api', 'user.active', 'active.session', 'validate.session', '2fa', 'super.admin')->group(function () {
        Route::get('/admin-actions', [AuditAdminController::class, 'adminAudit']);
        Route::get('/permission-audit', [AuditAdminController::class, 'permissionAudit']);
        Route::get('/admin/security-audit/overview', [AuditAdminController::class, 'overview']);
    });
});
