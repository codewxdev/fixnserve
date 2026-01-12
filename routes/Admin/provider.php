<?php

use App\Http\Controllers\Front\ProviderController;
use Illuminate\Support\Facades\Route;
 

//Customer Module Routes
Route::get('/service/providers',[ProviderController::class, 'index'])->name('provider.index');
Route::post('/service/store',[ProviderController::class, 'store'])->name('store.provider');