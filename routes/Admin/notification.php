<?php

use App\Http\Controllers\Front\MartController;
use App\Http\Controllers\Front\NotificationController;
use Illuminate\Support\Facades\Route;
 
//Notification Module Routes
Route::get('/notification',[NotificationController::class, 'index'])->name('notification.index');
 