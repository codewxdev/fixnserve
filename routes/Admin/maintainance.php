<?php

use App\Http\Controllers\Front\FinanceController;
use App\Http\Controllers\Front\MaintainanceController;
use App\Http\Controllers\Front\MartController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// Miantainance & Emergency MODULE
// ====================================================
Route::get('/maintainance/emergency', [MaintainanceController::class, 'index'])->name('maintainance.index');