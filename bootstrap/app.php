<?php

use App\Domains\Command\Middlewares\EnsureEmergencyOverrideMiddleware;
use App\Domains\Command\Middlewares\EnsureKillSwitch;
use App\Domains\Command\Models\KillSwitch;
use App\Http\Middleware\EnsureServiceProviderRole;
use App\Jobs\CalculateApiMetrics;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

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

        $middleware->alias([
            'active.session' => \App\Http\Middleware\EnsureActiveSession::class,
            'emergency' => EnsureEmergencyOverrideMiddleware::class,
            'kill' => EnsureKillSwitch::class,
            'check_maintenance' => App\Domains\Command\Middlewares\EnsureMaintenance::class,
            'health_api' => App\Domains\Command\Middlewares\EnsureApiHealthMetrics::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'super.admin' => \App\Http\Middleware\EnsureCheckSuperAdmin::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            '2fa' => \App\Http\Middleware\Ensure2FAEnabled::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'user.active' => \App\Http\Middleware\EnsureCheckUserStatus::class,
            'service.provider' => EnsureServiceProviderRole::class,
            'check_country' => App\Domains\Command\Middlewares\EnsureCountryStatus::class,
            'block_soft_country_orders' => App\Domains\Command\Middlewares\EnsureBlockOrdersForSoftDisabledCountry::class,
            // 'javed' => \App\Http\Middleware\Admin\AuthMiddleware::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('promotions:expire')->everyMinute()->withoutOverlapping()->onOneServer();
        $schedule->job(new CalculateApiMetrics)->everyMinute();
        $schedule->call(function () {
            // Activate scheduled maintenances
            App\Domains\Command\Models\Maintenance::where('status', 'scheduled')
                ->where('starts_at', '<=', now())
                ->update(['status' => 'active']);
            // Auto-expire finished maintenances
            App\Domains\Command\Models\Maintenance::where('status', 'active')
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
    })->create();
