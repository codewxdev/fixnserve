<?php

use App\Http\Controllers\Front\ProviderController;
use App\Http\Controllers\Front\RegionalController;
use Illuminate\Support\Facades\Route;
 

// ====================================================
// Regional Controle 
// ====================================================
Route::get('/regional_controle', [RegionalController::class, 'index'])->name('regional_controle.index');

