<?php

use App\Http\Controllers\Front\User\ConsultantController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/consultant/dashboard',[ConsultantController::class, 'index'])->name('consultant.dashboard');
