<?php

use App\Http\Controllers\Front\User\ConsultantController;
use App\Http\Controllers\Front\User\RiderController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/rider/dashboard',[RiderController::class, 'index'])->name('rider.dashboard');
