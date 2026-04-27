<?php

use App\Domains\RBAC\Controllers\Front\AccessMetrixController;
use App\Domains\RBAC\Controllers\Front\AuditGovernanceController;
use App\Domains\RBAC\Controllers\Front\PermissionController;
use App\Domains\RBAC\Controllers\Front\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 3: ROLES & PERMISSIONS)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web', 'auth.admin', 'admin.ip_whitelist'
])
->prefix('cp-x9f7a2/v1/rbac')
->name('cp.rbac.')
->group(function () {

    // Roles Management
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    // Permissions Management
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

    // Access Matrix (Role -> Permission Mapping)
    Route::get('/matrix', [AccessMetrixController::class, 'index'])->name('matrix');

    // RBAC Audit & Governance
    Route::get('/governance', [AuditGovernanceController::class, 'index'])->name('governance');

});