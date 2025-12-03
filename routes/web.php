<?php

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Authentication Routes
Route::get('/auth/login',[AuthController::class, 'index'])->name('login.index');
Route::get('/auth/forget/password',[AuthController::class, 'forget'])->name('forget.password');
