<?php

use App\Http\Controllers\Front\AuthController as FrontAuthController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


Route::get('/', function () {
    return view('admin.dashboard.index');
})->name('home');


// Authentication Routes
Route::get('/auth/login',[FrontAuthController::class, 'index'])->name('login.index');
Route::get('/auth/forget/password',[FrontAuthController::class, 'forget'])->name('forget.password');
Route::get('/auth/password/reset',[FrontAuthController::class, 'reset'])->name('reset.password');


 

