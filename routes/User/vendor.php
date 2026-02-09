<?php

use App\Http\Controllers\Front\User\VendorController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/vendor/dashboard',[VendorController::class, 'index'])->name('vendor.dashboard');
