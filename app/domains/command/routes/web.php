<?php

use App\Domains\Command\Controllers\Front\PlatformOverviewController;
use Illuminate\Support\Facades\Route;

Route::get('/platform-overview',[PlatformOverviewController::class,'index'])->name('platform_overview.index');