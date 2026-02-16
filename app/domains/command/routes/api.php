<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\KillSwitchController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\EmergencyOverrideController;


Route::middleware('health_api', 'check_country')->group(function () {
    Route::prefix('metrics')->group(function () {
        Route::get('/summary', [MetricsController::class, 'summary']);
        Route::get('/latency/timeseries', [MetricsController::class, 'latencyTimeSeries']);
        Route::get('/endpoints', [MetricsController::class, 'endpoints']);
        Route::get('/dependencies', [MetricsController::class, 'dependencies']);
    });

    // Main Authenticated Routes Group with User Status Check
    Route::middleware(['auth:api', 'user.active', 'active.session'])->group(function () {
       
        // Super Admin Routes (with additional checks)
        Route::middleware(['role:Super Admin', '2fa'])->group(function () {
            
            Route::put('/updateStatus', [ServiceController::class, 'updateStatus']);
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
            // /////////////////maintance route/////////////////
            Route::post('/maintenance', [MaintenanceController::class, 'store']);
            Route::get('/maintenance', [MaintenanceController::class, 'index']);
            Route::patch('/maintenance/{maintenance}', [MaintenanceController::class, 'updateStatus']);
            // //////////////////switchkill route////////////////
            Route::post('/kill/switch', [KillSwitchController::class, 'store']);
            Route::get('/kill/switch', [KillSwitchController::class, 'index']);
            Route::post('kill/switch/cancel/{id}', [KillSwitchController::class, 'cancel']);
            // ///////////////////emergency override route///////////////////
            Route::post('emergency-override/activate', [EmergencyOverrideController::class, 'activate']);
            Route::post('emergency-override/terminate', [EmergencyOverrideController::class, 'terminate']);
            Route::get('emergency-override/logs', [EmergencyOverrideController::class, 'logs']);
            Route::post('/critical-action', [EmergencyOverrideController::class, 'criticalAction'])->middleware('emergency');
           
    });
    
   
  

});