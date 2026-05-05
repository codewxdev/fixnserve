<?php

use App\Domains\Analytics\Controllers\Front\AnalyticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MODULE 11: PLATFORM ANALYTICS & REPORTING
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth.admin'])
->prefix('cp-x9f7a2/v1/analytics')
->name('cp.analytics.')
->group(function () {
    
    Route::get('/executive', [AnalyticsController::class, 'executive'])->name('executive');
    Route::get('/financial', [AnalyticsController::class, 'financial'])->name('financial');
    Route::get('/operational', [AnalyticsController::class, 'operational'])->name('operational');
    Route::get('/builder', [AnalyticsController::class, 'builder'])->name('builder');
    Route::get('/scheduled', [AnalyticsController::class, 'scheduled'])->name('scheduled');

});