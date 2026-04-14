<?php

use App\Domains\Disputes\Controllers\Api\AbuseEnforcementController;
use App\Domains\Disputes\Controllers\Api\AppealController;
use App\Domains\Disputes\Controllers\Api\ComplaintIntakeController;
use App\Domains\Disputes\Controllers\Api\EvidenceController;
use App\Domains\Disputes\Controllers\Api\LegalComplianceController;
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
        Route::prefix('abuse-enforcement')->group(function () {

            Route::get('/dashboard', [AbuseEnforcementController::class, 'dashboard']);
            Route::get('/', [AbuseEnforcementController::class, 'index']);
            Route::get('/export', [AbuseEnforcementController::class, 'export']);
            Route::get('/policy', [AbuseEnforcementController::class, 'getPolicy']);
            Route::put('/policy/{policy}', [AbuseEnforcementController::class, 'updatePolicy']);

            Route::get('/{detection}', [AbuseEnforcementController::class, 'show']);
            Route::post('/{detection}/enforce', [AbuseEnforcementController::class, 'manualEnforce']);
            Route::post('/{detection}/false-positive', [AbuseEnforcementController::class, 'markFalsePositive']);
            Route::post('/{detection}/sync-risk', [AbuseEnforcementController::class, 'syncToRiskModule']);

            Route::post('/enforcements/{enforcement}/lift', [AbuseEnforcementController::class, 'liftRestriction']);

            Route::get('/entity/{entityType}/{entityId}', [AbuseEnforcementController::class, 'entityHistory']);
        });
        Route::prefix('legal')->group(function () {

            Route::get('/dashboard', [LegalComplianceController::class, 'dashboard']);
            Route::get('/cases', [LegalComplianceController::class, 'index']);
            Route::post('/cases', [LegalComplianceController::class, 'store']);
            Route::get('/cases/{legalCase}', [LegalComplianceController::class, 'show']);
            Route::patch('/cases/{legalCase}/notes', [LegalComplianceController::class, 'addNotes']);
            Route::post('/cases/{legalCase}/seal', [LegalComplianceController::class, 'sealCase']);
            Route::post('/cases/{legalCase}/archive', [LegalComplianceController::class, 'archive']);
            Route::post('/cases/{legalCase}/hold', [LegalComplianceController::class, 'placeLegalHold']);
            Route::delete('/holds/{hold}/lift', [LegalComplianceController::class, 'liftLegalHold']);
            Route::post('/cases/{legalCase}/generate-bundle', [LegalComplianceController::class, 'generateBundle']);
            Route::get('/cases/{legalCase}/exports', [LegalComplianceController::class, 'listExports']);
            Route::get('/cases/{legalCase}/audit-trail', [LegalComplianceController::class, 'auditTrail']);
        });
        Route::middleware('legal.hold')->group(function () {
            Route::post('complaints/{complaint}/create-case', [ComplaintIntakeController::class, 'createCase']);
            Route::patch('complaints/{complaint}/reclassify', [ComplaintIntakeController::class, 'reclassify']);
            Route::post('appeals/{appeal}/assign-reviewer', [AppealController::class, 'assignReviewer']);
            Route::post('appeals/{appeal}/uphold', [AppealController::class, 'uphold']);
            Route::post('appeals/{appeal}/overturn', [AppealController::class, 'overturn']);
            Route::post('appeals/{appeal}/partial-decision', [AppealController::class, 'partialDecision']);
            Route::post('appeals/{appeal}/lock-case', [AppealController::class, 'lockCase']);

            Route::post('refunds/{refund}/approve', [RefundEngineController::class, 'approve']);
            Route::post('refunds/{refund}/reject', [RefundEngineController::class, 'reject']);
            Route::post('refunds/{refund}/partial', [RefundEngineController::class, 'partialRefund']);
            Route::post('refunds/{refund}/escalate-finance', [RefundEngineController::class, 'escalateToFinance']);
        });
        Route::prefix('evidence')->group(function () {

            Route::get('/dashboard', [EvidenceController::class, 'dashboard']);
            Route::get('/', [EvidenceController::class, 'index']);
            Route::post('/', [EvidenceController::class, 'store']);
            Route::get('/timeline', [EvidenceController::class, 'timeline']);
            Route::get('/{evidence}', [EvidenceController::class, 'show']);
            Route::post('/{evidence}/lock', [EvidenceController::class, 'lock']);
            Route::post('/{evidence}/flag-tampering', [EvidenceController::class, 'flagTampering']);
            Route::post('/{evidence}/share', [EvidenceController::class, 'share']);
            Route::get('/{evidence}/verify', [EvidenceController::class, 'verifyIntegrity']);
        });
    });
});
