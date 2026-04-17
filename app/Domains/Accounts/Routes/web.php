<?php

use App\Domains\Accounts\Controllers\Front\CustomerController;
use App\Domains\Accounts\Controllers\Front\ProfessionalController;
use App\Domains\Accounts\Controllers\Front\ProviderController;
use App\Domains\Accounts\Controllers\Front\ConsultantController;
use App\Domains\Accounts\Controllers\Front\MartController;
use App\Domains\Accounts\Controllers\Front\RiderController;
 
use Illuminate\Support\Facades\Route;

// ====================================================
// Customer Routes
// ====================================================
Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');


// ====================================================
// Service Providers Routes 
// ====================================================
Route::get('/providers', [ProviderController::class, 'index'])->name('provider.index');
Route::post('/providers', [ProviderController::class, 'store'])->name('store.provider');


// ====================================================
// Professional Experts Routes
// ====================================================
Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professional.index');
Route::post('/professionals', [ProfessionalController::class, 'store'])->name('store.professional');


// ====================================================
// Consultant Routes
// ====================================================
Route::get('/consultants', [ConsultantController::class, 'index'])->name('consultant.index');
Route::post('/consultants', [ConsultantController::class, 'store'])->name('store.consultant');


// ====================================================
// Mart Vendors Routes
// ==================================================== 
Route::get('/mart/vendors', [MartController::class, 'index'])->name('mart.index');
Route::post('/mart/vendors', [MartController::class, 'store'])->name('store.mart');


// ===================================================
//  Rider Routes 
// ===================================================
Route::get('/riders', [RiderController::class, 'index'])->name('rider.index');
Route::post('/riders', [RiderController::class, 'store'])->name('store.rider');