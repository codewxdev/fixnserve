<?php

use App\Domains\Fraud\Controllers\Front\FraudController;
use Illuminate\Support\Facades\Route;

Route::get('/fraud',[FraudController::class,'index'])->name('fraud.risk_scoring_engine');
Route::get('/fraud/session-identity-risk',[FraudController::class,'SessionIdentityRisk'])->name('fraud.session_Identity_Risk');
Route::get('/fraud/payment_wallet',[FraudController::class,'PaymentWallet'])->name('fraud.payment_wallet');
Route::get('/fraud/promotion_incentive_abuse',[FraudController::class,'PromotionIncentiveAbuse'])->name('fraud.promotion_incentive_abuse');
Route::get('/fraud/collusion_networks',[FraudController::class,'CollusionNetworks'])->name('fraud.collusion_networks');
Route::get('/fraud/automated_enforcement_engine',[FraudController::class,'AutomatedEnforcementEngine'])->name('fraud.automated_enforcement_engine');
Route::get('/fraud/manual_overrides_governance',[FraudController::class,'ManualOverridesGovernance'])->name('fraud.manual_overrides_governance');

