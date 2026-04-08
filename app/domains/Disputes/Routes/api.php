<?php

use App\Domains\Disputes\Controllers\Api\ComplaintIntakeController;
use App\Domains\Disputes\Controllers\Api\RefundEngineController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
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
            Route::post('/', [RefundEngineController::class, 'store']);
            Route::get('/preview', [RefundEngineController::class, 'calculatePreview']);
            Route::get('/policy', [RefundEngineController::class, 'getPolicy']);
            Route::put('/policy/{policy}', [RefundEngineController::class, 'updatePolicy']);
            Route::get('/{refund}', [RefundEngineController::class, 'show']);
            Route::post('/{refund}/approve', [RefundEngineController::class, 'approve']);
            Route::post('/{refund}/reject', [RefundEngineController::class, 'reject']);
            Route::post('/{refund}/partial', [RefundEngineController::class, 'partialRefund']);
            Route::post('/{refund}/escalate-finance', [RefundEngineController::class, 'escalateToFinance']);
        });

    });
});
