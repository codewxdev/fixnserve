<?php

use App\Domains\Fraud\Controllers\Api\RiskScoringController;
use App\Domains\Fraud\Controllers\Api\SessionIdentityRiskController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
    Route::middleware(['auth:api', 'role:Super Admin', '2fa', 'user.active', 'active.session'])->group(function () {
        Route::prefix('risk')->group(function () {

            // ✅ Dashboard
            Route::get('/dashboard', [RiskScoringController::class, 'dashboard']);

            // ✅ Live Feed
            Route::get('/entities', [RiskScoringController::class, 'liveRiskFeed']);

            // ✅ Critical
            Route::get('/critical', [RiskScoringController::class, 'criticalEntities']);

            // ✅ Signal Weights
            Route::get('/signals/weights', [RiskScoringController::class, 'getSignalWeights']);
            Route::put('/signals/weights', [RiskScoringController::class, 'updateSignalWeights']);

            // ✅ Submit Event
            Route::post('/events', [RiskScoringController::class, 'submitEvent']);

            // ✅ Entity specific
            Route::prefix('entities/{entityType}/{entityId}')->group(function () {
                Route::get('/', [RiskScoringController::class, 'entityDetail']);
                Route::post('/rescore', [RiskScoringController::class, 'manualRescore']);
                Route::get('/history', [RiskScoringController::class, 'entityHistory']);
                Route::post('/enforce', [RiskScoringController::class, 'manualEnforce']);
            });
        });
        Route::prefix('session-risk')->group(function () {

            // ✅ Dashboard
            Route::get('/dashboard',
                [SessionIdentityRiskController::class, 'dashboard']);

            // ✅ Live Sessions
            Route::get('/sessions',
                [SessionIdentityRiskController::class, 'liveSessions']);

            Route::get('/sessions/{sessionId}',
                [SessionIdentityRiskController::class, 'sessionDetail']);

            Route::delete('/sessions/{sessionId}',
                [SessionIdentityRiskController::class, 'terminateSession']);

            Route::delete('/sessions/purge-bots',
                [SessionIdentityRiskController::class, 'purgeBotSessions']);

            // ✅ Session Actions
            Route::post('/sessions/{sessionId}/lock',
                [SessionIdentityRiskController::class, 'temporaryLock']);

            Route::post('/sessions/{sessionId}/unlock',
                [SessionIdentityRiskController::class, 'unlockSession']);

            Route::post('/sessions/{sessionId}/stepup-auth',
                [SessionIdentityRiskController::class, 'triggerStepupAuth']);

            Route::post('/sessions/{sessionId}/notify',
                [SessionIdentityRiskController::class, 'notifyUser']);

            // ✅ IP Blocks
            Route::get('/ip-blocks',
                [SessionIdentityRiskController::class, 'getIpBlocks']);

            Route::post('/ip-blocks',
                [SessionIdentityRiskController::class, 'blockIp']);

            Route::delete('/ip-blocks/{ip}',
                [SessionIdentityRiskController::class, 'unblockIp']);

            // ✅ Geo Velocity Alerts
            Route::get('/geo-velocity-alerts',
                [SessionIdentityRiskController::class, 'geoVelocityAlerts']);

            Route::patch('/geo-velocity-alerts/{alert}/dismiss',
                [SessionIdentityRiskController::class, 'dismissGeoAlert']);

            Route::patch('/geo-velocity-alerts/{alert}/review',
                [SessionIdentityRiskController::class, 'reviewGeoAlert']);
        });

    });
});
