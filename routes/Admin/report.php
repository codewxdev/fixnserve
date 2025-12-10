<?php

use App\Http\Controllers\Front\ProviderController;
use App\Http\Controllers\Front\ReportController;
use Illuminate\Support\Facades\Route;
 

//Customer Module Routes
Route::get('/reports/analytics',[ReportController::class, 'index'])->name('report.index');