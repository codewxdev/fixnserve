<?php

use App\Http\Controllers\Front\ProfessionalController;
use Illuminate\Support\Facades\Route;
 
//professional Module Routes
Route::get('/professional/experts',[ProfessionalController::class, 'index'])->name('professional.index');
 