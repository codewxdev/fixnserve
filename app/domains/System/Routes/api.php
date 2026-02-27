<?php

use App\Domains\System\Controllers\Api\PlatformPreferenceController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {
    Route::middleware(['auth:api', 'role:Super Admin', '2fa', 'user.active', 'active.session'])
        ->prefix('admin/platform-preferences')
        ->group(function () {

            Route::post('/update', [PlatformPreferenceController::class, 'update']);
            Route::get('/current', [PlatformPreferenceController::class, 'current']);

        });
});
