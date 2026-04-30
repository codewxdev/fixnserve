<?php

use App\Domains\Security\Controllers\Api\V1\AuthController;
use App\Domains\Security\Controllers\Cp\V1\AuthGovernanceController;
use App\Domains\Security\Controllers\Cp\V1\DeviceController;
use App\Domains\Security\Controllers\Cp\V1\DualApprovalController;
use App\Domains\Security\Controllers\Cp\V1\GeoRuleController;
use App\Domains\Security\Controllers\Cp\V1\IpRuleController;
use App\Domains\Security\Controllers\Cp\V1\PrivilegeRequestController;
use App\Domains\Security\Controllers\Cp\V1\SessionController;
use App\Domains\Security\Controllers\Cp\V1\TokenPolicyController;
use Illuminate\Support\Facades\Route;

Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);

Route::middleware(
    'health_api', 'check_country', 'country.detect', 'locale.set', 'currency.set',
    'language.initialize', 'risk.track', 'risk.velocity', 'session.risk'
)->group(function () {

    Route::post('/2fa/enable', [AuthController::class, 'enable2FA']);

    // Main Authenticated Routes Group with User Status Check
    //  'user.active', 'active.session', 'device.bind', 'token.role', 'network.security'
    Route::middleware([
        'auth:api',
        'user.active',
        'active.session',
        'device.bind',
        'token.role',
        'network.security',
        'risk.track',
        'risk.velocity',
    ])->group(function () {

        // Auth Routes

        // Super Admin Routes (with additional checks)
        Route::middleware(['role:Super Admin', '2fa', 'scope:admin:*'])->group(function () {
            Route::get('/login-history', [AuthController::class, 'loginHistory']);
            // /////////////////////session management//////////////////////////
            Route::prefix('sessions')->group(function () {
                Route::get('/', [SessionController::class, 'index']);
                Route::get('{id}', [SessionController::class, 'show']);

                Route::post('{id}/revoke', [SessionController::class, 'revoke']);
                Route::post('{id}/flag', [SessionController::class, 'flag']);

                Route::post('revoke-all', [SessionController::class, 'revokeAll']);
                Route::post('revoke-role', [SessionController::class, 'revokeByRole']);
                // Route::post('revoke-region', [SessionController::class, 'revokeByRegion']);
            });
            // //////////////////////auth governance route//////////////////////
            Route::prefix('auth-governance')->group(function () {

                Route::get('/', [AuthGovernanceController::class, 'index']);

                Route::post('/login-methods', [AuthGovernanceController::class, 'updateLoginMethods']);

                Route::post('/mfa', [AuthGovernanceController::class, 'updateMFA']);

                Route::post('/password-rules', [AuthGovernanceController::class, 'updatePasswordRules']);

                Route::post('/force-reset', [AuthGovernanceController::class, 'forcePasswordReset']);
            });

            Route::prefix('token-policy')->group(function () {
                Route::get('/', [TokenPolicyController::class, 'index']);
                Route::put('/', [TokenPolicyController::class, 'updateTokenPolicy']);
                Route::get('/tokens', [TokenPolicyController::class, 'listTokens']);
                Route::post('/{jti}/rotate', [AuthController::class, 'rotateToken']);
                Route::delete('/revoke/{jti}', [AuthController::class, 'revokeToken']);
            });

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

            Route::prefix('security-network')->group(function () {

                Route::apiResource('ip-rules', IpRuleController::class);

                Route::get('geo-rules', [GeoRuleController::class, 'index']);
                Route::post('geo-rules/country', [GeoRuleController::class, 'updateCountry']);
                Route::patch('geo-rules/default/policy', [GeoRuleController::class, 'updateDefault']);
            });
        });

        Route::prefix('privileges')->group(function () {
            Route::get('/', [PrivilegeRequestController::class, 'index']);
            Route::post('/request', [PrivilegeRequestController::class, 'requestElevation']);
            Route::post('/approve/{id}', [PrivilegeRequestController::class, 'approve']);
            Route::post('/deny/{id}', [PrivilegeRequestController::class, 'deny']);
            Route::post('/extend/{id}', [PrivilegeRequestController::class, 'extend']);
            Route::post('/terminate/{id}', [PrivilegeRequestController::class, 'terminate']);
        });
        Route::prefix('dual-approval')->group(function () {
            Route::post('/request', [DualApprovalController::class, 'requestAction']);
            Route::post('/approve-level1/{id}', [DualApprovalController::class, 'approveLevel1']);
            Route::post('/approve-level2/{id}', [DualApprovalController::class, 'approveLevel2']);
            Route::post('/execute/{id}', [DualApprovalController::class, 'execute']);

            Route::get('/audit-logs', [DualApprovalController::class, 'auditApprovalLogs']);
        });
    });
});
