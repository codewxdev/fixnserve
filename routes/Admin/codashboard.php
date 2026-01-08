<?php

use App\Http\Controllers\Front\CmsController;
use App\Http\Controllers\Front\CodashboardController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/codashboard',[CodashboardController::class, 'index'])->name('codashboard.index');
