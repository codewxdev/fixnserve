<?php

use App\Http\Controllers\Front\ServiceController;
use Illuminate\Support\Facades\Route;
 

//Service Module Routes
Route::get('/service/managment',[ServiceController::class, 'index'])->name('service.index');

Route::post('/service/categories', [ServiceController::class, 'storeCategory'])->name('store.category');
Route::post('/service/subcategories', [ServiceController::class, 'storeSubcategory'])->name('store.subcategory');
Route::post('/specialties', [ServiceController::class, 'storeSpecialty'])->name('store.specialty');
Route::post('/sub-specialties', [ServiceController::class, 'storeSubSpecialty'])->name('store.subspecialty');