<?php

use App\Http\Controllers\Front\RiderController;
use Illuminate\Support\Facades\Route;
 

// ====================================================
// RIDER MODULE
// ====================================================
Route::get('/riders', [RiderController::class, 'index'])->name('rider.index');
Route::post('/riders', [RiderController::class, 'store'])->name('store.rider');