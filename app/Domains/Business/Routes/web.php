<?php

use App\Domains\Business\Controllers\Front\BusinessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 4: BUSINESS ACCOUNTS)
|-------------------------------------------------------------------------- 
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',                  // Standard Laravel web stack (CSRF, Cookies)
    'auth.admin',           // Authenticated admin session
    'admin.ip_whitelist',   // VerifyIpWhitelist Middleware
])
->prefix('cp-x9f7a2/v1/businesses')
->name('cp.businesses.')
->group(function () {
    
    // ========================================================
    // SUB-MODULE 4.1: BUSINESS REGISTRY
    // ========================================================
    
     Route::get('/', [BusinessController::class, 'index'])->name('index');
    
     


    // ========================================================
    // SUB-MODULE 4.2: BUSINESS LIFECYCLE
    // ========================================================
    
    // Dedicated view for lifecycle management and transitions
    Route::get('/lifecycle-management', [BusinessController::class, 'lifecycle'])->name('lifecycle');
 
    // ========================================================
    // SUB-MODULE 4.3: BUSINESS INTELLIGENCE & ACTIONS
    // ========================================================
    
     Route::post('/{business_id}/actions/force-logout', [BusinessController::class, 'forceLogoutTeam'])->name('actions.force_logout');
    
    
     
});