<?php

use App\Domains\Command\Controllers\Front\MaintainanceController;
use App\Domains\Command\Controllers\Front\PlatformOverviewController;
use App\Domains\Command\Controllers\Front\RegionalController;
use App\Domains\Command\Controllers\Front\SystemHealthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/cp-x9f7/v1')->group(function () {
    Route::get('/platform-overview', [PlatformOverviewController::class, 'index'])->name('platform_overview.index');
    Route::get('/maintainance-emergency', [MaintainanceController::class, 'index'])->name('maintainance_emergency.index');
    Route::get('/system-health', [SystemHealthController::class, 'index'])->name('system_health.index');
    Route::get('/regional-controle', [RegionalController::class, 'index'])->name('regional_controle.index');
});

Route::put('/countries/{id}', function (Request $request, $id) {
    $country = \App\Models\Country::findOrFail($id);
    $country->update(['status' => $request->status]);
    return response()->json(['success' => true]);
});