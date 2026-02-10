<?php

use App\Http\Controllers\Front\ServiceController;
use Illuminate\Support\Facades\Route;
 

// ====================================================
// SERVICE MANAGEMENT (Categories, Specialties, etc.)
// ====================================================
Route::get('/services/management', [ServiceController::class, 'index'])->name('service.index');

// Create
Route::post('/services/categories', [ServiceController::class, 'storeCategory'])->name('store.category');
Route::post('/services/sub-categories', [ServiceController::class, 'storeSubcategory'])->name('store.subcategory');
Route::post('/services/specialties', [ServiceController::class, 'storeSpecialty'])->name('store.specialty');
Route::post('/services/sub-specialties', [ServiceController::class, 'storeSubSpecialty'])->name('store.subspecialty');

// Update (Added prefix for standard hierarchy)
Route::put('/services/categories/{id}', [ServiceController::class, 'updateCategory'])->name('update.category');
Route::put('/services/sub-categories/{id}', [ServiceController::class, 'updateSubcategory'])->name('update.subcategory');
Route::put('/services/specialties/{id}', [ServiceController::class, 'updateSpecialty'])->name('update.specialty');
Route::put('/services/sub-specialties/{id}', [ServiceController::class, 'updateSubSpecialty'])->name('update.subspecialty');

// Delete (Added prefix for standard hierarchy)
Route::delete('/services/categories/{id}', [ServiceController::class, 'destroyCategory'])->name('destroy.category');
Route::delete('/services/sub-categories/{id}', [ServiceController::class, 'destroySubcategory'])->name('destroy.subcategory');
Route::delete('/services/specialties/{id}', [ServiceController::class, 'destroySpecialty'])->name('destroy.specialty');
Route::delete('/services/sub-specialties/{id}', [ServiceController::class, 'destroySubSpecialty'])->name('destroy.subspecialty');

// Status Toggles (Using concise 'status' endpoint)
Route::patch('/services/categories/{id}/status', [ServiceController::class, 'toggleCategoryStatus']);
Route::patch('/services/sub-categories/{id}/status', [ServiceController::class, 'toggleSubcategoryStatus']);
Route::patch('/services/specialties/{id}/status', [ServiceController::class, 'toggleSpecialtyStatus']);
Route::patch('/services/sub-specialties/{id}/status', [ServiceController::class, 'toggleSubSpecialtyStatus']);