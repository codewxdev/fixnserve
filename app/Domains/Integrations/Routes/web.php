<?php

use App\Domains\Integrations\Controllers\Front\ExternalIntegrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 16: EXTERNAL INTEGRATIONS
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/integrations')
->name('cp.integrations.')
->group(function () {
    
    Route::get('/registry', [ExternalIntegrationController::class, 'registry'])->name('registry');
    Route::get('/credentials', [ExternalIntegrationController::class, 'credentials'])->name('credentials');
    Route::get('/health-monitoring', [ExternalIntegrationController::class, 'health'])->name('health');
    Route::get('/webhook-governance', [ExternalIntegrationController::class, 'webhooks'])->name('webhooks');
    Route::get('/vendor-performance', [ExternalIntegrationController::class, 'vendors'])->name('vendors');

});