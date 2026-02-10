<?php

use App\Http\Controllers\Front\SystemHealthController;
use Illuminate\Support\Facades\Route;
 

// ====================================================
// SUBSCRIPTION MODULE
// ====================================================
Route::get('/system-health', [SystemHealthController::class, 'index'])->name('system_health.index');