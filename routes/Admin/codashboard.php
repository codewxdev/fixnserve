<?php

use App\Http\Controllers\Front\CmsController;
use App\Http\Controllers\Front\CodashboardController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// CODASHBOARD
// ====================================================
Route::get('/dashboard/co', [CodashboardController::class, 'index'])->name('codashboard.index');
