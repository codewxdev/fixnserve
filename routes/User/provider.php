<?php

use App\Http\Controllers\Front\User\ProviderController as UserProviderController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/provider/dashboard',[UserProviderController::class, 'index'])->name('provider.dashboard');
