<?php

use App\Domains\System\Controllers\Front\SystemController;
use Illuminate\Support\Facades\Route;


Route::get('/system', [SystemController::class, 'index'])->name('settings.global');

Route::get('/system/feature-control', [SystemController::class, 'featureControl'])->name('settings.feature_control'); 

Route::get('/system/localization', [SystemController::class, 'localization'])->name('settings.localization'); 