<?php

use App\Http\Controllers\Front\AuthController as FrontAuthController;
use Illuminate\Support\Facades\Route;

// Super Admin Routes (with additional checks)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('Admin.dashboard.index');
    })->name('dashboard.index');
});


// Authentication Routes
Route::get('/auth/login', [FrontAuthController::class, 'index'])->name('login');
Route::get('/auth/forget/password', [FrontAuthController::class, 'forget'])->name('forget.password');
Route::get('/auth/password/reset', [FrontAuthController::class, 'reset'])->name('reset.password');
