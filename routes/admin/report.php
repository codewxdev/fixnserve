<?php

use App\Http\Controllers\Front\ProviderController;
use App\Http\Controllers\Front\ReportController;
use Illuminate\Support\Facades\Route;
 

// ====================================================
// REPORTS & ANALYTICS
// ====================================================
Route::get('/reports/analytics', [ReportController::class, 'index'])->name('report.index');