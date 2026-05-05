<?php

use App\Domains\Disputes\Controllers\Front\DisputeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 10: PLATFORM DISPUTES
|--------------------------------------------------------------------------
| Handles B2B disputes between Sahor One and connected businesses.
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/platform-disputes')
->name('cp.disputes.')
->group(function () {
    
    Route::get('/categories', [DisputeController::class, 'types'])->name('types');
    Route::get('/active-workflow', [DisputeController::class, 'workflow'])->name('workflow');
    Route::get('/evidence-vault', [DisputeController::class, 'evidence'])->name('evidence');
    Route::get('/ai-triage', [DisputeController::class, 'triage'])->name('triage');
    Route::get('/legal-escalations', [DisputeController::class, 'escalations'])->name('escalations');

});