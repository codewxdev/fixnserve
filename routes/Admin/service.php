<?php

use App\Http\Controllers\Front\ServiceController;
use Illuminate\Support\Facades\Route;
 

//Service Module Routes
Route::get('/service/managment',[ServiceController::class, 'index'])->name('service.index');