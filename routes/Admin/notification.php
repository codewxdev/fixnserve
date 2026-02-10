<?php

use App\Http\Controllers\Front\MartController;
use App\Http\Controllers\Front\NotificationController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// NOTIFICATION MODULE
// ====================================================
Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');