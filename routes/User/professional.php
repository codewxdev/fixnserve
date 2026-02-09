<?php

use App\Http\Controllers\Front\User\ProfessionalController;
use App\Http\Controllers\Front\User\ProviderController as UserProviderController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/professional/dashboard',[ProfessionalController::class, 'index'])->name('professional.dashboard');
