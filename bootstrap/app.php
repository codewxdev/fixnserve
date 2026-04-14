<?php

use App\Domains\Command\Jobs\CalculateApiMetrics;
use App\Domains\Command\Middlewares\EnsureApiHealthMetrics;
use App\Domains\Command\Middlewares\EnsureBlockOrdersForSoftDisabledCountry;
use App\Domains\Command\Middlewares\EnsureCountryStatus;
use App\Domains\Command\Middlewares\EnsureEmergencyOverrideMiddleware;
use App\Domains\Command\Middlewares\EnsureKillSwitch;
use App\Domains\Command\Middlewares\EnsureMaintenance;
use App\Domains\Command\Models\KillSwitch;
use App\Domains\Command\Models\Maintenance;
use App\Domains\Disputes\Middlewares\AutoGenerateComplaint;
use App\Domains\Disputes\Middlewares\CheckAbuseRestrictions;
use App\Domains\Disputes\Middlewares\StartSlaTracking;
use App\Domains\Disputes\Middlewares\ValidateAppealEligibility;
use App\Domains\Fraud\Middlewares\DetectDeviceReuse;
use App\Domains\Fraud\Middlewares\DetectGeoInconsistency;
use App\Domains\Fraud\Middlewares\DetectVelocityPattern;
use App\Domains\Fraud\Middlewares\ScanCollusionAbuse;
use App\Domains\Fraud\Middlewares\ScanPaymentAbuse;
use App\Domains\Fraud\Middlewares\ScanPromoAbuse;
use App\Domains\Fraud\Middlewares\SessionRiskMiddleware;
use App\Domains\Fraud\Middlewares\TrackRiskEvent;
use App\Domains\RBAC\Middlewares\EnsureServiceProviderRole;
use App\Domains\Security\Middlewares\CheckDeviceBinding;
use App\Domains\Security\Middlewares\CheckNetworkSecurity;
use App\Domains\Security\Middlewares\CheckScope;
use App\Domains\Security\Middlewares\CheckTokenRole;
use App\Domains\Security\Middlewares\Ensure2FAEnabled;
use App\Domains\Security\Middlewares\EnsureActiveSession;
use App\Domains\Security\Middlewares\LoginMethodPolicyMiddleware;
use App\Domains\Security\Middlewares\MFAPolicyMiddleware;
use App\Domains\Security\Middlewares\ValidateUserSession;
use App\Domains\Security\Models\DualApproval;
use App\Domains\System\Middlewares\ApplyPlatformDefaults;
use App\Domains\System\Middlewares\CaptureConfigVersion;
use App\Domains\System\Middlewares\CheckFeatureFlag;
use App\Domains\System\Middlewares\CheckGeoLocation;
use App\Domains\System\Middlewares\CheckRateLimit;
use App\Domains\System\Middlewares\DetectCountry;
use App\Domains\System\Middlewares\EnforceReasonCode;
use App\Domains\System\Middlewares\InitializeLanguage;
use App\Domains\System\Middlewares\SetCurrency;
use App\Domains\System\Middlewares\SetLocale;
use App\Http\Middleware\EnsureCheckUserStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {

            Route::namespace('admin')->group(base_path('routes/admin/customer.php'));
            Route::namespace('admin')->group(base_path('routes/admin/provider.php'));
            Route::namespace('admin')->group(base_path('routes/admin/professional.php'));
            Route::namespace('admin')->group(base_path('routes/admin/role_permission.php'));
            Route::namespace('admin')->group(base_path('routes/admin/consultant.php'));
            Route::namespace('admin')->group(base_path('routes/admin/mart.php'));
            Route::namespace('admin')->group(base_path('routes/admin/rider.php'));
            Route::namespace('admin')->group(base_path('routes/admin/service.php'));
            Route::namespace('admin')->group(base_path('routes/admin/finance.php'));
            Route::namespace('admin')->group(base_path('routes/admin/car.php'));
            Route::namespace('admin')->group(base_path('routes/admin/report.php'));
            Route::namespace('admin')->group(base_path('routes/admin/cms.php'));
            Route::namespace('admin')->group(base_path('routes/admin/notification.php'));
            Route::namespace('admin')->group(base_path('routes/admin/cooperation.php'));
            Route::namespace('admin')->group(base_path('routes/admin/codashboard.php'));
            Route::namespace('admin')->group(base_path('routes/admin/subscription.php'));
            Route::namespace('admin')->group(base_path('routes/admin/marketing.php'));
            Route::namespace('admin')->group(base_path('routes/admin/system_health.php'));
            Route::namespace('admin')->group(base_path('routes/admin/regional_controle.php'));
            Route::namespace('admin')->group(base_path('routes/admin/maintainance.php'));
            Route::namespace('admin')->group(base_path('routes/admin/platform_overview.php'));
            Route::namespace('user')->group(base_path('routes/user/provider.php'));
            Route::namespace('user')->group(base_path('routes/user/professional.php'));
            Route::namespace('user')->group(base_path('routes/user/consultant.php'));
            Route::namespace('user')->group(base_path('routes/user/rider.php'));
            Route::namespace('user')->group(base_path('routes/user/vendor.php'));

        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Correct way to register middleware aliases in Laravel 11/12
        $middleware->encryptCookies(except: [
            'token',
        ]);
        $middleware->use([
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
        $middleware->appendToGroup('api', [
            CheckRateLimit::class,
            DetectDeviceReuse::class,
            DetectGeoInconsistency::class,
            SessionRiskMiddleware::class,
            CheckAbuseRestrictions::class,
        ]);

        $middleware->alias([
            'country.detect' => DetectCountry::class,
            'locale.set' => SetLocale::class,
            'currency.set' => SetCurrency::class,
            'language.initialize' => InitializeLanguage::class,
            'platform.context' => ApplyPlatformDefaults::class,
            'network.security' => CheckNetworkSecurity::class,
            'device.bind' => CheckDeviceBinding::class,
            'token.role' => CheckTokenRole::class,
            'scope' => CheckScope::class,
            'validate.session' => ValidateUserSession::class,
            'login.policy' => LoginMethodPolicyMiddleware::class,
            'mfa.policy' => MFAPolicyMiddleware::class,
            'active.session' => EnsureActiveSession::class,
            'emergency' => EnsureEmergencyOverrideMiddleware::class,
            'kill' => EnsureKillSwitch::class,
            'check_maintenance' => EnsureMaintenance::class,
            'health_api' => EnsureApiHealthMetrics::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'super.admin' => \App\Domains\RBAC\Middlewares\EnsureCheckSuperAdmin::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            '2fa' => Ensure2FAEnabled::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'user.active' => EnsureCheckUserStatus::class,
            'service.provider' => EnsureServiceProviderRole::class,
            'check_country' => EnsureCountryStatus::class,
            'block_soft_country_orders' => EnsureBlockOrdersForSoftDisabledCountry::class,
            'geo.checkLocation' => CheckGeoLocation::class,
            'feature' => CheckFeatureFlag::class,
            'reason.code' => EnforceReasonCode::class,
            'version.capture' => CaptureConfigVersion::class,
            'risk.track' => TrackRiskEvent::class,
            'risk.device' => DetectDeviceReuse::class,
            'risk.geo' => DetectGeoInconsistency::class,
            'risk.velocity' => DetectVelocityPattern::class,
            'session.risk' => SessionRiskMiddleware::class,
            'payment.abuse.scan' => ScanPaymentAbuse::class,
            'collusion.scan' => ScanCollusionAbuse::class,
            'complaint.auto' => AutoGenerateComplaint::class,
            'promo.abuse.scan' => ScanPromoAbuse::class,   // //////////use on promo application routes
            'appeal.eligible' => ValidateAppealEligibility::class, // / check on appeal submission routes
            'sla.track' => StartSlaTracking::class,       // ///////`use on complaint/appeal/refund creation routes
            'abuse.check' => CheckAbuseRestrictions::class,
            'legal.hold' => \App\Domains\Disputes\Middlewares\CheckLegalHold::class, // / check on any route that modifies user/order data that could be under legal hold

        ]);

    })
    ->withExceptions(function ($exceptions) {

        // Model / Route not found
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found',
                'language' => app()->getLocale(),
                'data' => [],
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ], 404);
        });

        // Validation error
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'language' => app()->getLocale(),
                'data' => [
                    'errors' => $e->errors(),
                ],
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ], 422);
        });

    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // $schedule->command('update:api-controllers')->weekly();
        $schedule->command('promotions:expire')->everyMinute();
        $schedule->command('security:password-rotation')->daily();
        $schedule->command('privileges:revoke-expired')->everyMinute();
        $schedule->command('complaints:check-sla')->everyFiveMinutes();
        $schedule->job(new CalculateApiMetrics)->everyMinute();
        $schedule->call(function () {
            // Activate scheduled maintenances
            Maintenance::where('status', 'scheduled')
                ->where('starts_at', '<=', now())
                ->update(['status' => 'active']);
            // Auto-expire finished maintenances
            Maintenance::where('status', 'active')
                ->whereNotNull('ends_at')
                ->where('ends_at', '<=', now())
                ->update(['status' => 'cancelled']);
            cache()->forget('maintenance:active');
        })->everyMinute();
        $schedule->call(function () {
            // 🔥 Push active kill switches to Redis
            KillSwitch::where('status', 'active')->get()->each(function ($kill) {
                // ⏰ Auto-expire check
                if ($kill->expires_at && $kill->expires_at->isPast()) {
                    $kill->update(['status' => 'expired']);
                    Redis::del("kill_switch:{$kill->scope}");

                    return;
                }
                Redis::set(
                    "kill_switch:{$kill->scope}",
                    json_encode([
                        'id' => $kill->id,
                        'type' => $kill->type,
                        'expires_at' => $kill->expires_at,
                    ])
                );
            });

        })->everyMinute();
        $schedule->command('privileges:revoke')->everyMinute();
        DualApproval::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

    })->create();
