<?php

use App\Http\Controllers\Front\CustomerController;
use Illuminate\Support\Facades\Route;
 
//Customer Module Routes
Route::get('/customer/details',[CustomerController::class, 'index'])->name('customer.index');
 