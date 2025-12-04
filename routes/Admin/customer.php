<?php

use App\Http\Controllers\Front\CustomerController;
use Illuminate\Support\Facades\Route;
 

Route::get('/customer/details',[CustomerController::class, 'index'])->name('customer.index');