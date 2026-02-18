<?php

use App\Domains\Security\Controllers\Api\AuthController;
use App\Domains\Security\Controllers\Api\AuthGovernanceController;
use App\Domains\Security\Controllers\Api\PasswordResetCodeController;
use App\Domains\Security\Controllers\Api\SessionController;
use App\Http\Controllers\ServiceProvider\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware(['throttle:login', 'login.policy']);
    Route::post('/password/forgot', [PasswordResetCodeController::class, 'sendResetCode']);
    Route::post('/password/verify-code', [PasswordResetCodeController::class, 'verifyCode']);
    Route::post('/password/reset', [PasswordResetCodeController::class, 'resetPassword']);
    Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);
    Route::post('/2fa/enable', [AuthController::class, 'enable2FA']);

    // Main Authenticated Routes Group with User Status Check
    Route::middleware(['auth:api', 'user.active', 'active.session'])->group(function () {

        // Auth Routes
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::post('/update/profile/{id}', [AuthController::class, 'updateProfile']);

        // Route::middleware(['service.provider'])->group(function () {
        Route::post('/phone/verify', [AuthController::class, 'verifyPhoneOtp']);

        // Super Admin Routes (with additional checks)
        Route::middleware(['role:Super Admin', '2fa'])->group(function () {

            Route::get('/login-history', [AuthController::class, 'loginHistory']);

            Route::put('/updateStatus', [ServiceController::class, 'updateStatus']);

            // /////////////////////session managment//////////////////////////
            Route::prefix('sessions')->group(function () {
                Route::get('/', [SessionController::class, 'index']);
                Route::get('{id}', [SessionController::class, 'show']);

                Route::post('{id}/revoke', [SessionController::class, 'revoke']);
                Route::post('{id}/flag', [SessionController::class, 'flag']);

                Route::post('revoke-all', [SessionController::class, 'revokeAll']);
                Route::post('revoke-role', [SessionController::class, 'revokeByRole']);
                // Route::post('revoke-region', [SessionController::class, 'revokeByRegion']);
            });

            // ///////////////////////auth governance route//////////////////////
            Route::prefix('auth/governance')->group(function () {

                Route::get('/', [AuthGovernanceController::class, 'index']);

                Route::post('/login-methods', [AuthGovernanceController::class, 'updateLoginMethods']);

                Route::post('/mfa', [AuthGovernanceController::class, 'updateMFA']);

                Route::post('/password-rules', [AuthGovernanceController::class, 'updatePasswordRules']);

                Route::post('/force-reset', [AuthGovernanceController::class, 'forcePasswordReset']);
            });

        });

    });

});
