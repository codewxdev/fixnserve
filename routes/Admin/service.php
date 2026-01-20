<?php

use App\Http\Controllers\Front\ServiceController;
use Illuminate\Support\Facades\Route;
 

//Service Module Routes
Route::get('/service/managment',[ServiceController::class, 'index'])->name('service.index');

Route::post('/service/categories', [ServiceController::class, 'storeCategory'])->name('store.category');
Route::post('/service/subcategories', [ServiceController::class, 'storeSubcategory'])->name('store.subcategory');
Route::post('/specialties', [ServiceController::class, 'storeSpecialty'])->name('store.specialty');
Route::post('/sub-specialties', [ServiceController::class, 'storeSubSpecialty'])->name('store.subspecialty');


// Edit/Update Routes
Route::put('/categories/{id}', [ServiceController::class, 'updateCategory'])->name('update.category');
Route::put('/subcategories/{id}', [ServiceController::class, 'updateSubcategory'])->name('update.subcategory');
Route::put('/specialties/{id}', [ServiceController::class, 'updateSpecialty'])->name('update.specialty');
Route::put('/sub-specialties/{id}', [ServiceController::class, 'updateSubSpecialty'])->name('update.subspecialty');

// Delete Routes
Route::delete('/categories/{id}', [ServiceController::class, 'destroyCategory'])->name('destroy.category');
Route::delete('/subcategories/{id}', [ServiceController::class, 'destroySubcategory'])->name('destroy.subcategory');
Route::delete('/specialties/{id}', [ServiceController::class, 'destroySpecialty'])->name('destroy.specialty');
Route::delete('/sub-specialties/{id}', [ServiceController::class, 'destroySubSpecialty'])->name('destroy.subspecialty');


// Status Toggles
Route::patch('/categories/{id}/toggle-status', [ServiceController::class, 'toggleCategoryStatus']);
Route::patch('/subcategories/{id}/toggle-status', [ServiceController::class, 'toggleSubcategoryStatus']);
Route::patch('/specialties/{id}/toggle-status', [ServiceController::class, 'toggleSpecialtyStatus']);
Route::patch('/sub-specialties/{id}/toggle-status', [ServiceController::class, 'toggleSubSpecialtyStatus']);