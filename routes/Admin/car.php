<?php

use App\Http\Controllers\Front\CarController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/complaints-refunds/reports', [CarController::class, 'index'])->name('car.index');