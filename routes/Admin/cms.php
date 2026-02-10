<?php

use App\Http\Controllers\Front\CmsController;
use Illuminate\Support\Facades\Route;
 
/// ====================================================
// CMS MODULE
// ====================================================
Route::get('/cms/settings', [CmsController::class, 'index'])->name('cms.index');