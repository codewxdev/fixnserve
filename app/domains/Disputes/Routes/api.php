<?php

use App\Domains\Disputes\Controllers\Api\AppealController;
use App\Domains\Disputes\Controllers\Api\ComplaintIntakeController;
use App\Domains\Disputes\Controllers\Api\RefundEngineController;
use App\Domains\Disputes\Controllers\Api\SlaEscalationController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
    Route::post('refunds', [RefundEngineController::class, 'store']);
    Route::middleware(['auth:api', 'role:Super Admin', '2fa', 'user.active', 'active.session'])->group(function () {

        Route::prefix('complaints')->group(function () {
            Route::get('/dashboard', [ComplaintIntakeController::class, 'dashboard']);
            Route::get('/queue', [ComplaintIntakeController::class, 'priorityQueue']);
            Route::post('/', [ComplaintIntakeController::class, 'store']);
            Route::get('/{complaint}', [ComplaintIntakeController::class, 'show']);
            Route::post('/{complaint}/create-case', [ComplaintIntakeController::class, 'createCase']);
            Route::patch('/{complaint}/reclassify', [ComplaintIntakeController::class, 'reclassify']);

            // Rules & SLA
            Route::get('/config/rules', [ComplaintIntakeController::class, 'getClassificationRules']);
            Route::get('/config/sla', [ComplaintIntakeController::class, 'getSlaConfigs']);
            Route::put('/config/sla/{slaConfig}', [ComplaintIntakeController::class, 'updateSlaConfig']);

            Route::get('/export', [ComplaintIntakeController::class, 'export']);
        });
        Route::prefix('refunds')->group(function () {

            Route::get('/dashboard', [RefundEngineController::class, 'dashboard']);
            Route::get('/', [RefundEngineController::class, 'index']);
            Route::get('/preview', [RefundEngineController::class, 'calculatePreview']);
            Route::get('/policy', [RefundEngineController::class, 'getPolicy']);
            Route::put('/policy/{policy}', [RefundEngineController::class, 'updatePolicy']);
            Route::get('/{refund}', [RefundEngineController::class, 'show']);
            Route::post('/{refund}/approve', [RefundEngineController::class, 'approve']);
            Route::post('/{refund}/reject', [RefundEngineController::class, 'reject']);
            Route::post('/{refund}/partial', [RefundEngineController::class, 'partialRefund']);
            Route::post('/{refund}/escalate-finance', [RefundEngineController::class, 'escalateToFinance']);
        });
        Route::prefix('appeals')->group(function () {

            // ✅ Admin routes
            Route::get('/dashboard', [AppealController::class, 'dashboard']);
            Route::get('/', [AppealController::class, 'index']);
            Route::get('/export', [AppealController::class, 'export']);
            Route::get('/policy', [AppealController::class, 'getPolicy']);
            Route::put('/policy/{policy}', [AppealController::class, 'updatePolicy']);

            // ✅ User routes
            Route::get('/check-eligibility', [AppealController::class, 'checkEligibility']);

            Route::post(
                '/',
                [AppealController::class, 'store']
            )->middleware('appeal.eligible');

            // ✅ Detail & Evidence
            Route::get('/{appeal}', [AppealController::class, 'show']);
            Route::post('/{appeal}/add-evidence', [AppealController::class, 'addEvidence']);

            // ✅ Review Actions (Admin)
            Route::post('/{appeal}/assign-reviewer', [AppealController::class, 'assignReviewer']);
            Route::post('/{appeal}/uphold', [AppealController::class, 'uphold']);
            Route::post('/{appeal}/overturn', [AppealController::class, 'overturn']);
            Route::post('/{appeal}/partial-decision', [AppealController::class, 'partialDecision']);
            Route::post('/{appeal}/lock-case', [AppealController::class, 'lockCase']);
        });
        Route::prefix('sla')->group(function () {
            Route::get('/dashboard', [SlaEscalationController::class, 'dashboard']);
            Route::get('/trackings', [SlaEscalationController::class, 'index']);
            Route::get('/trackings/breached', [SlaEscalationController::class, 'breachedCases']);
            Route::get('/trackings/{slaTracking}', [SlaEscalationController::class, 'show']);
            Route::get('/trackings/{slaTracking}/history', [SlaEscalationController::class, 'escalationHistory']);

            Route::post('/trackings/{slaTracking}/escalate', [SlaEscalationController::class, 'escalate']);
            Route::post('/trackings/{slaTracking}/intervene', [SlaEscalationController::class, 'supervisorIntervene']);
            Route::post('/check-breaches', [SlaEscalationController::class, 'checkBreaches']);

            Route::get('/configs', [SlaEscalationController::class, 'getSlaConfigs']);
            Route::put('/configs/{config}', [SlaEscalationController::class, 'updateSlaConfig']);

            Route::get('/rules', [SlaEscalationController::class, 'getEscalationRules']);
            Route::put('/rules/{rule}', [SlaEscalationController::class, 'updateEscalationRule']);
        });

    });
});
