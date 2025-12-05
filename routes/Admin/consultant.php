<?php

use App\Http\Controllers\Front\ConsultantController;
use Illuminate\Support\Facades\Route;
 
//Consultant Module Routes
Route::get('/consultant',[ConsultantController::class, 'index'])->name('consultant.index');
