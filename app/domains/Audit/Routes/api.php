<?php

use App\Domains\Audit\Controllers\Api\AuditAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {
    Route::middleware('auth:api', 'user.active', 'active.session', 'validate.session', 'role:Super Admin', '2fa')->group(function () {
        Route::get('/admin-actions', [AuditAdminController::class, 'adminAudit']);
        Route::get('/permission-audit', [AuditAdminController::class, 'permissionAudit']);
        Route::get('/admin/security-audit/overview', [AuditAdminController::class, 'overview']);
        Route::get('/admin/security-audit', [AuditAdminController::class, 'securityAudit']);
    });
});
