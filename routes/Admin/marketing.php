<?php

use App\Http\Controllers\Front\FinanceController;
use App\Http\Controllers\Front\MarketingController;
use Illuminate\Support\Facades\Route;
 
// ====================================================
// MARKETING MODULE
// ====================================================
Route::get('/marketing/coupons',[MarketingController::class, 'coupon'])->name('marketing.coupons');
Route::get('/marketing/campaigns',[MarketingController::class, 'campaign'])->name('marketing.campaigns');
Route::get('/marketing/loyalty',[MarketingController::class, 'loyalty'])->name('marketing.loyalty');
Route::get('/marketing/featured',[MarketingController::class, 'featured'])->name('marketing.featured');
 