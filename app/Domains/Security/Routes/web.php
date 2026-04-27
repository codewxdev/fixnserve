<?php

use App\Domains\Security\Controllers\Front\SecurityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 2: SECURITY & ACCESS)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',                  // Standard Laravel web stack (CSRF, Cookies)
    'auth.admin',           // Authenticated admin session
    // 'admin.mfa',            // RequireMFA Middleware
    'admin.ip_whitelist',   // VerifyIpWhitelist Middleware
    // 'admin.device_trust',   // RequireDeviceTrust Middleware
])
->prefix('cp-x9f7a2/v1/security')
->name('cp.security.')
->group(function () {
    
    // Authentication & Policies
    Route::get('/policies', [SecurityController::class, 'policies'])->name('policies');
    
    // Sessions Management
    Route::get('/sessions', [SecurityController::class, 'sessions'])->name('sessions');
    
    // Token & API Key Management
    Route::get('/tokens', [SecurityController::class, 'tokens'])->name('tokens');
    
    // Device Trust & Fingerprinting
    Route::get('/devices', [SecurityController::class, 'devices'])->name('devices');
    
    // Network Security (IP Allow/Deny, Geo)
    Route::get('/network', [SecurityController::class, 'network'])->name('network');
    
    // Privileged Access (Just-In-Time)
    Route::get('/privileged-access', [SecurityController::class, 'jit'])->name('jit');

});