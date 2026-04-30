<?php

use App\Domains\Fraud\Controllers\Api\CollusionDetectionController;
use App\Domains\Fraud\Controllers\Api\PaymentAbuseController;
use App\Domains\Fraud\Controllers\Api\RiskScoringController;
use App\Domains\Fraud\Controllers\Api\SessionIdentityRiskController;
use Illuminate\Support\Facades\Route;

Route::post('risk/events', [RiskScoringController::class, 'submitEvent']);
Route::delete('/session-risk/sessions/purge-bots',
    [SessionIdentityRiskController::class, 'purgeBotSessions']);

// ✅ IP Blocks
Route::get('session-risk/ip-blocks',
    [SessionIdentityRiskController::class, 'getIpBlocks']);

Route::post('session-risk/ip-blocks',
    [SessionIdentityRiskController::class, 'blockIp']);

Route::delete('session-risk/ip-blocks/{ip}',
    [SessionIdentityRiskController::class, 'unblockIp']);

Route::post('payment-abuse/transactions/{detection}/delay-payout', [PaymentAbuseController::class, 'delayPayout']);

Route::post('payment-abuse/transactions/{detection}/suspend-dispatch', [PaymentAbuseController::class, 'suspendDispatch']);

Route::post('collusion/rings/{ring}/freeze-payouts', [CollusionDetectionController::class, 'freezePayouts']);
