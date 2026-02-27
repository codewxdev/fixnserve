<?php

use App\Domains\Audit\Controllers\Api\AuditAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/admin-actions', [AuditAdminController::class, 'adminAudit']);
    Route::get('/permission-audit', [AuditAdminController::class, 'permissionAudit']);
});
