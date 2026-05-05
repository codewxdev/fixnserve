<?php

use App\Domains\AI\Controllers\Front\AIAutomationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 15: AI & AUTOMATION
|--------------------------------------------------------------------------
| Platform-wide intelligence, rule engines, and model governance.
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/ai-automation')
->name('cp.ai.')
->group(function () {
    
    Route::get('/orchestrator', [AIAutomationController::class, 'orchestrator'])->name('orchestrator');
    Route::get('/business-intelligence', [AIAutomationController::class, 'intelligence'])->name('intelligence');
    Route::get('/fraud-models', [AIAutomationController::class, 'fraud'])->name('fraud');
    Route::get('/operations-ai', [AIAutomationController::class, 'operations'])->name('operations');
    Route::get('/rule-engine', [AIAutomationController::class, 'engine'])->name('engine');
    Route::get('/human-in-the-loop', [AIAutomationController::class, 'hitl'])->name('hitl');
    Route::get('/model-governance', [AIAutomationController::class, 'governance'])->name('governance');

});