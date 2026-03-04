<?php

use App\Domains\System\Controllers\Front\SystemController;
use Illuminate\Support\Facades\Route;


Route::get('/system', [SystemController::class, 'index'])->name('settings.global');