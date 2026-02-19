<?php

use App\Domains\RBAC\Controllers\Front\AccessMetrixController;
use App\Domains\RBAC\Controllers\Front\AuditGovernanceController;
use App\Domains\RBAC\Controllers\Front\PermissionController;
use App\Domains\RBAC\Controllers\Front\RoleController;
use Illuminate\Support\Facades\Route;

// Roles Routes
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');


// Permissions Routes
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');


// Access Matrix Route
Route::get('/access-matrix', [AccessMetrixController::class, 'index'])->name('access-matrix.index');


// Audit & Governance Route
Route::get('/audit-governance', [AuditGovernanceController::class, 'index'])->name('audit-governance.index');