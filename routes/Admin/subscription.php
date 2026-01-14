<?php

use App\Http\Controllers\Front\SubscriptionController;
use Illuminate\Support\Facades\Route;
 

//Service Module Routes
Route::get('/subscription/managment',[SubscriptionController::class, 'index'])->name('subscription.index');
Route::post('/subscription-plans', [SubscriptionController::class, 'store'])->name('plans.store');