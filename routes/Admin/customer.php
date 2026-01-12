<?php

use App\Http\Controllers\Front\CustomerController;
use Illuminate\Support\Facades\Route;
 
//Customer Module Routes
Route::get('/customer/details',[CustomerController::class, 'index'])->name('customer.index');
Route::post('/customer/store',[CustomerController::class, 'store'])->name('customers.store');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');