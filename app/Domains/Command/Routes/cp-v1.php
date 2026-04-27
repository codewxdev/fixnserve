<?php

use App\Domains\Command\Controllers\Cp\V1\EmergencyOverrideController;
use App\Domains\Command\Controllers\Cp\V1\IncidentController;
use App\Domains\Command\Controllers\Cp\V1\KillSwitchController;
use App\Domains\Command\Controllers\Cp\V1\MaintenanceController;
use App\Domains\Command\Controllers\Cp\V1\MetricsController;
use App\Domains\Command\Controllers\Cp\V1\QueueController;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
    // ///// Health metrics routes //////////
    Route::prefix('metrics')->group(function () {
        Route::get('/summary', [MetricsController::class, 'summary']);
        Route::get('/latency-timeseries', [MetricsController::class, 'latencyTimeSeries']);
        Route::get('/endpoints', [MetricsController::class, 'endpoints']);
        Route::get('/dependencies', [MetricsController::class, 'dependencies']);
        Route::get('/incidents', [IncidentController::class, 'index']);
        Route::get('/queues-health', [QueueController::class, 'health']);
    });
    // Main Authenticated Routes Group with User Status Check
    Route::middleware(['auth:api', 'user.active', 'active.session'])->group(function () {

        // Super Admin Routes (with additional checks)
        Route::middleware(['role:Super Admin', '2fa'])->group(function () {

            // //////////disable country status////////////////
            Route::patch('/countries/{id}', function (Request $request, $id) {
                $request->validate([
                    'status' => 'required|in:enabled,soft_disabled,hard_disabled',
                ]);
                $country = Country::findorfail($id);
                $res = $country->update([
                    'status' => $request->status,
                ]);

                return response()->json([
                    'success' => true,
                    'response' => $res,
                ]);
            });
            // /////////////////maintenance route/////////////////
            Route::prefix('maintenance')->group(function () {
                Route::post('/', [MaintenanceController::class, 'store']);
                Route::get('/', [MaintenanceController::class, 'index']);
                Route::patch('/{maintenance}', [MaintenanceController::class, 'updateStatus']);
            });
            // //////////////////switch kill route////////////////
            Route::prefix('kill-switch')->group(function () {
                Route::post('/', [KillSwitchController::class, 'store']);
                Route::get('/', [KillSwitchController::class, 'index']);
                Route::post('/cancel/{id}', [KillSwitchController::class, 'cancel']);
            });
            // ///////////////////emergency override route///////////////////
            Route::prefix('emergency-override')->group(function () {
                Route::post('/activate', [EmergencyOverrideController::class, 'activate']);
                Route::post('/terminate', [EmergencyOverrideController::class, 'terminate']);
                Route::get('/logs', [EmergencyOverrideController::class, 'logs']);
                Route::post('/critical-action', [EmergencyOverrideController::class, 'criticalAction'])->middleware('emergency');
            });
        });
    });

});
