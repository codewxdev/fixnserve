<?php

use App\Http\Controllers\Front\RiderController;
use Illuminate\Support\Facades\Route;
 

//Rider Module Routes
Route::get('/riders',[RiderController::class, 'index'])->name('rider.index');