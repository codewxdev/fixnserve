<?php

use App\Domains\KYC\Controllers\Front\KycController;
use Illuminate\Support\Facades\Route;


Route::prefix('/cp-x9f7/v1')->group(function () {
Route::get('/kyc',[KycController::class,'index'])->name('admin.document.managment');
Route::get('/kyc/ai-verification-pipeline',[KycController::class,'AiVerificationPipeline'])->name('admin.ai.verification.pipeline');
Route::get('/kyc/ai-verification-pipeline',[KycController::class,'AiVerificationPipeline'])->name('admin.ai.verification.pipeline');
Route::get('/kyc-orchestration-engine',[KycController::class,'OrchestrationEngine'])->name('admin.orchestration.engine');
Route::get('/kyc/entity-specific-controls',[KycController::class,'EntitySpecificControls'])->name('admin.entity.specific.controls');
Route::get('/kyc/compliance_governance',[KycController::class,'ComplianceGovernance'])->name('admin.compliance_governance');


});