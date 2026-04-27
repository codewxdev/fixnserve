<?php

use App\Domains\Billing\Controllers\Front\PlanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SAHOR ONE CONTROL PANEL (MODULE 6: BILLING & MONETIZATION)
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',                  // Standard Laravel web stack (CSRF, Cookies)
    'auth.admin',           // Authenticated admin session
    'admin.ip_whitelist',   // VerifyIpWhitelist Middleware
])
->prefix('cp-x9f7a2/v1/billing/plans')
->name('cp.billing.plans.')
->group(function () {
    
    // ========================================================
    // SUB-MODULE 6.1: GLOBAL BILLING CONFIGURATION
    // ========================================================
    
    


    // ========================================================
    // SUB-MODULE 6.1: PLAN DIRECTORY & CRUD
    // ========================================================
    
     Route::get('/', [PlanController::class, 'index'])->name('index');
    
 

});