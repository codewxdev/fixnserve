<?php

use App\Http\Controllers\Front\FinanceController;
use App\Http\Controllers\Front\MartController;
use Illuminate\Support\Facades\Route;
 
//Mart Module Routes
Route::get('/finance',[FinanceController::class, 'index'])->name('finance.index');
 