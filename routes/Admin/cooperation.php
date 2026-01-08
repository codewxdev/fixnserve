<?php

use App\Http\Controllers\Front\CooperateController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/cooperate',[CooperateController::class, 'index'])->name('cooperation.index');
