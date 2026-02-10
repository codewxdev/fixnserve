<?php

use App\Http\Controllers\Front\FinanceController;
use App\Http\Controllers\Front\MartController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// FINANCE MODULE
// ====================================================
Route::get('/finance/overview', [FinanceController::class, 'index'])->name('finance.index');