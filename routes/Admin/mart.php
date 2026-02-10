<?php

use App\Http\Controllers\Front\MartController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// MART MODULE
// ====================================================
Route::get('/mart/vendors', [MartController::class, 'index'])->name('mart.index');
Route::post('/mart/vendors', [MartController::class, 'store'])->name('store.mart');