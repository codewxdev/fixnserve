<?php

use App\Http\Controllers\Front\SubscriptionController;
use Illuminate\Support\Facades\Route;
 

//Service Module Routes
Route::get('/subscription/managment',[SubscriptionController::class, 'index'])->name('subscription.index');
Route::post('/subscriptions/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
Route::put('/subscriptions/update/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
Route::delete('/subscriptions/delete/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.delete');
