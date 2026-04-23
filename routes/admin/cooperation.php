<?php

use App\Http\Controllers\Front\CooperateController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// COOPERATIONS MODULE
// ====================================================
Route::get('/cooperations', [CooperateController::class, 'index'])->name('cooperation.index');