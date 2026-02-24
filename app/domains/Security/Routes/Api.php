<?php

use App\Domains\Security\Controllers\Api\AuthController;
use App\Domains\Security\Controllers\Api\AuthGovernanceController;
use App\Domains\Security\Controllers\Api\DeviceController;
use App\Domains\Security\Controllers\Api\DualApprovalController;
use App\Domains\Security\Controllers\Api\GeoRuleController;
use App\Domains\Security\Controllers\Api\IpRuleController;
use App\Domains\Security\Controllers\Api\PasswordResetCodeController;
use App\Domains\Security\Controllers\Api\PrivilegeRequestController;
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
    Route::middleware(['auth:api', 'user.active', 'active.session', 'validate.session', 'device.bind', 'token.role', 'network.security'])->group(function () {

        // Auth Routes
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::post('/update/profile/{id}', [AuthController::class, 'updateProfile']);

        // Route::middleware(['service.provider'])->group(function () {
        Route::post('/phone/verify', [AuthController::class, 'verifyPhoneOtp']);

        // Super Admin Routes (with additional checks)
        Route::middleware(['role:Super Admin', '2fa', 'scope:admin:*', 'token.role'])->group(function () {
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
            Route::get('/token-policy', [\App\Domains\Security\Controllers\Api\TokenPolicyController::class, 'index']);
            Route::put('/token-policy', [\App\Domains\Security\Controllers\Api\TokenPolicyController::class, 'updateTokenPolicy']);
            Route::get('tokens', [\App\Domains\Security\Controllers\Api\TokenPolicyController::class, 'listTokens']);
            Route::post('/tokens/{jti}/rotate', [AuthController::class, 'rotateToken']);
            Route::delete('/auth/token/revoke/{jti}', [AuthController::class, 'revokeToken']);

            Route::prefix('devices')->group(function () {
                Route::get('/policies', [DeviceController::class, 'getPolicies']);
                Route::post('/policy', [DeviceController::class, 'storeOrUpdatePolicy']);
                Route::get('/insights', [DeviceController::class, 'insights']);
                Route::get('/', [DeviceController::class, 'index']);

                Route::post('{device}/trust', [DeviceController::class, 'trust']);
                Route::post('{device}/revoke', [DeviceController::class, 'revoke']);
                Route::post('{device}/ban', [DeviceController::class, 'ban']);
                Route::post('{device}/unban', [DeviceController::class, 'unban']);
            });

            Route::prefix('admin/security/network')->group(function () {

                Route::apiResource('ip-rules', IpRuleController::class);

                Route::get('geo-rules', [GeoRuleController::class, 'index']);
                Route::post('geo-rules/country', [GeoRuleController::class, 'updateCountry']);
                Route::patch('geo-rules/default-policy', [GeoRuleController::class, 'updateDefault']);

            });
        });

        Route::post('/privileges/request', [PrivilegeRequestController::class, 'requestElevation']);
        Route::post('/privileges/approve/{id}', [PrivilegeRequestController::class, 'approve']);
        Route::post('/privileges/deny/{id}', [PrivilegeRequestController::class, 'deny']);
        Route::post('/privileges/extend/{id}', [PrivilegeRequestController::class, 'extend']);
        Route::post('/privileges/terminate/{id}', [PrivilegeRequestController::class, 'terminate']);

        Route::post('/dual-approval/request', [DualApprovalController::class, 'requestAction']);
        Route::post('/dual-approval/approve-level1/{id}', [DualApprovalController::class, 'approveLevel1']);
        Route::post('/dual-approval/approve-level2/{id}', [DualApprovalController::class, 'approveLevel2']);
        Route::post('/dual-approval/execute/{id}', [DualApprovalController::class, 'execute']);

        Route::get('/dual-approval/audit-logs', [DualApprovalController::class, 'auditApprovalLogs']);
    });

});
