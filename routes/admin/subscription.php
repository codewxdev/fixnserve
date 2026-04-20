<?php

use App\Http\Controllers\Front\SubscriptionController;
use Illuminate\Support\Facades\Route;
 

// ====================================================
// SUBSCRIPTION MODULE
// ====================================================
Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy'])->name('subscriptions.delete');