<?php

use App\Domains\Fraud\Controllers\Sys\V1\FraudController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize')->group(function () {
    Route::middleware(['auth:api', 'role:Super Admin', '2fa', 'user.active', 'active.session'])->group(function () {
        Route::post('risk/events', [FraudController::class, 'submitEvent']);
        Route::delete('/session-risk/sessions/purge-bots',
            [FraudController::class, 'purgeBotSessions']);

        // ✅ IP Blocks
        Route::get('session-risk/ip-blocks',
            [FraudController::class, 'getIpBlocks']);

        Route::post('session-risk/ip-blocks',
            [FraudController::class, 'blockIp']);

        Route::delete('session-risk/ip-blocks/{ip}',
            [FraudController::class, 'unblockIp']);

        Route::post('payment-abuse/transactions/{detection}/delay-payout', [FraudController::class, 'delayPayout']);

        Route::post('payment-abuse/transactions/{detection}/suspend-dispatch', [FraudController::class, 'suspendDispatch']);

        Route::post('collusion/rings/{ring}/freeze-payouts', [FraudController::class, 'freezePayouts']);
    });
});
