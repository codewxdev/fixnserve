<?php

use App\Domains\Security\Controllers\Front\SecuirtyController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/security/auth', [SecuirtyController::class, 'index'])->name('security.auth.index');

// Sessions Routes
Route::get('/security/sessions', [SecuirtyController::class, 'sessions'])->name('security.sessions.index');

// Tokens Routes
Route::get('/security/tokens', [SecuirtyController::class, 'tokens'])->name('security.tokens.index');

// Devices Routes
Route::get('/security/devices', [SecuirtyController::class, 'devices'])->name('security.devices.index');

// Network Security Routes
Route::get('/security/network', [SecuirtyController::class, 'network'])->name('security.network.index');

// Privileged Access Routes
Route::get('/security/privileged-access', [SecuirtyController::class, 'privilegedAccess'])->name('security.privileged_access.index');