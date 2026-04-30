<?php

use App\Domains\Fraud\Controllers\Cp\V1\CollusionDetectionController;
use App\Domains\Fraud\Controllers\Cp\V1\ManualOverrideController;
use App\Domains\Fraud\Controllers\Cp\V1\PaymentAbuseController;
use App\Domains\Fraud\Controllers\Cp\V1\PromoAbuseController;
use App\Domains\Fraud\Controllers\Cp\V1\RiskScoringController;
use App\Domains\Fraud\Controllers\Cp\V1\SessionIdentityRiskController;
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
            Route::get('/signals-weights', [RiskScoringController::class, 'getSignalWeights']);
            Route::put('/signals-weights', [RiskScoringController::class, 'updateSignalWeights']);

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

            // ✅ Session Actions
            Route::post('/sessions/{sessionId}/lock',
                [SessionIdentityRiskController::class, 'temporaryLock']);

            Route::post('/sessions/{sessionId}/unlock',
                [SessionIdentityRiskController::class, 'unlockSession']);

            Route::post('/sessions/{sessionId}/stepup-auth',
                [SessionIdentityRiskController::class, 'triggerStepupAuth']);

            Route::post('/sessions/{sessionId}/notify',
                [SessionIdentityRiskController::class, 'notifyUser']);

            // ✅ Geo Velocity Alerts
            Route::get('/geo-velocity-alerts',
                [SessionIdentityRiskController::class, 'geoVelocityAlerts']);

            Route::patch('/geo-velocity-alerts/{alert}/dismiss',
                [SessionIdentityRiskController::class, 'dismissGeoAlert']);

            Route::patch('/geo-velocity-alerts/{alert}/review',
                [SessionIdentityRiskController::class, 'reviewGeoAlert']);
        });
        Route::prefix('manual-overrides')->group(function () {

            // ✅ Dashboard + Lists
            Route::get('/dashboard', [ManualOverrideController::class, 'dashboard']);
            Route::get('/', [ManualOverrideController::class, 'index']);
            Route::get('/pending-dual', [ManualOverrideController::class, 'pendingDualApprovals']);
            Route::get('/{override}', [ManualOverrideController::class, 'show']);

            // ✅ Actions
            Route::post('/', [ManualOverrideController::class, 'store']);
            Route::post('/{override}/approve-level1', [ManualOverrideController::class, 'approveLevel1']);
            Route::post('/{override}/approve-level2', [ManualOverrideController::class, 'approveLevel2']);
            Route::post('/{override}/reject', [ManualOverrideController::class, 'reject']);
            Route::post('/{override}/execute', [ManualOverrideController::class, 'execute']);

            // ✅ Audit
            Route::get('/audit/log', [ManualOverrideController::class, 'auditLog']);
            Route::get('/audit/export', [ManualOverrideController::class, 'exportLog']);

            // ✅ Reason Codes
            Route::get('/reason/codes', [ManualOverrideController::class, 'getReasonCodes']);
        });
        Route::prefix('payment-abuse')->group(function () {

            // ✅ Dashboard
            Route::get('/dashboard', [PaymentAbuseController::class, 'dashboard']);

            // ✅ Transaction Feed
            Route::get('/transactions', [PaymentAbuseController::class, 'transactionFeed']);

            // ✅ Threat Patterns
            Route::get('/threat-patterns', [PaymentAbuseController::class, 'threatPatterns']);

            // ✅ Velocity Limits
            Route::get('/velocity-limits', [PaymentAbuseController::class, 'getVelocityLimits']);
            Route::put('/velocity-limits', [PaymentAbuseController::class, 'updateVelocityLimits']);

            // ✅ Detection Actions
            Route::post('/transactions/{detection}/freeze-wallet', [PaymentAbuseController::class, 'freezeWallet']);

            Route::post('/transactions/{detection}/manual-review', [PaymentAbuseController::class, 'manualReview']);

            Route::post('/transactions/{detection}/false-positive', [PaymentAbuseController::class, 'markFalsePositive']);
            Route::post('/transactions/{detection}/resolve', [PaymentAbuseController::class, 'resolve']);

            // ✅ Export
            Route::get('/export', [PaymentAbuseController::class, 'exportLogs']);
        });
        Route::prefix('promo-abuse')->group(function () {

            Route::get('/dashboard', [PromoAbuseController::class, 'dashboard']);
            Route::get('/monitor', [PromoAbuseController::class, 'liveMonitor']);
            Route::get('/referral-graph', [PromoAbuseController::class, 'referralGraph']);
            Route::get('/rules', [PromoAbuseController::class, 'getPromoRules']);
            Route::put('/rules', [PromoAbuseController::class, 'configurePromoRules']);

            Route::post('/detections/{detection}/invalidate', [PromoAbuseController::class, 'invalidatePromo']);
            Route::post('/detections/{detection}/clawback', [PromoAbuseController::class, 'rewardClawback']);
            Route::post('/detections/{detection}/restrict-account', [PromoAbuseController::class, 'restrictAccount']);
            Route::post('/detections/{detection}/false-positive', [PromoAbuseController::class, 'markFalsePositive']);
            Route::post('/detections/{detection}/resolve', [PromoAbuseController::class, 'resolve']);

            Route::get('/export', [PromoAbuseController::class, 'exportLogs']);
        });
        Route::prefix('collusion')->group(function () {

            Route::get('/dashboard', [CollusionDetectionController::class, 'dashboard']);
            Route::get('/rings', [CollusionDetectionController::class, 'liveRings']);
            Route::get('/rings/{ring}', [CollusionDetectionController::class, 'ringDetail']);
            Route::get('/interaction-graph', [CollusionDetectionController::class, 'interactionGraph']);

            // ✅ Enforcement Actions
            Route::post('/rings/{ring}/shadow-ban', [CollusionDetectionController::class, 'shadowBan']);
            Route::post('/rings/{ring}/suppress-ranking', [CollusionDetectionController::class, 'suppressRanking']);
            Route::post('/rings/{ring}/open-investigation', [CollusionDetectionController::class, 'openInvestigation']);
            Route::post('/rings/{ring}/quarantine-reviews', [CollusionDetectionController::class, 'quarantineReviews']);

            Route::post('/rings/{ring}/false-positive', [CollusionDetectionController::class, 'markFalsePositive']);
            Route::post('/rings/{ring}/resolve', [CollusionDetectionController::class, 'resolve']);

            // ✅ Bulk
            Route::post('/bulk-ban', [CollusionDetectionController::class, 'bulkBan']);

            // ✅ Export
            Route::get('/export', [CollusionDetectionController::class, 'exportLogs']);
        });

    });
});
