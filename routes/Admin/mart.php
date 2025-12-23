<?php

use App\Http\Controllers\Front\MartController;
use Illuminate\Support\Facades\Route;
 
//Mart Module Routes
Route::get('/mart/vendors',[MartController::class, 'index'])->name('mart.index');
 