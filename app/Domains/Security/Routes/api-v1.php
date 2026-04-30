<?php

use App\Domains\Security\Controllers\Api\V1\AuthController;
use App\Domains\Security\Controllers\Api\V1\PasswordResetCodeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set', 'language.initialize', 'risk.track', 'risk.velocity', 'session.risk'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/update/profile/{id}', [AuthController::class, 'updateProfile']);
    Route::post('/password/update', [AuthController::class, 'updatePassword']);
    Route::post('/phone/verify', [AuthController::class, 'verifyPhoneOtp']);
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware('login.policy');
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    Route::post('/password/forgot', [PasswordResetCodeController::class, 'sendResetCode']);
    Route::post('/password/verify-code', [PasswordResetCodeController::class, 'verifyCode']);
    Route::post('/password/reset', [PasswordResetCodeController::class, 'resetPassword']);

});
