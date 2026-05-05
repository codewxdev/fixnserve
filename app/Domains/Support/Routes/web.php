<?php

use App\Domains\Support\Controllers\Front\SupportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 12: SUPPORT & OPERATIONS
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/support')
->name('cp.support.')
->group(function () {
    
    Route::get('/tickets', [SupportController::class, 'tickets'])->name('tickets');
    Route::get('/sla-management', [SupportController::class, 'sla'])->name('sla');
    Route::get('/agent-workspace', [SupportController::class, 'workspace'])->name('workspace');
    Route::get('/incidents', [SupportController::class, 'incidents'])->name('incidents');
    Route::get('/knowledge-base', [SupportController::class, 'knowledge'])->name('knowledge');
    Route::get('/ai-assistant', [SupportController::class, 'assistant'])->name('assistant');

});