<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (): void {

            Route::namespace('admin')->group(base_path('routes/Admin/customer.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/provider.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/professional.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/role_permission.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/consultant.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/mart.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/rider.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/service.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/finance.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/car.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/report.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/cms.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/notification.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/cooperation.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/codashboard.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/subscription.php'));
            Route::namespace('admin')->group(base_path('routes/Admin/marketing.php'));
            Route::namespace('user')->group(base_path('routes/User/provider.php'));
            Route::namespace('user')->group(base_path('routes/User/professional.php'));
            Route::namespace('user')->group(base_path('routes/User/consultant.php'));
            Route::namespace('user')->group(base_path('routes/User/rider.php'));
            Route::namespace('user')->group(base_path('routes/User/vendor.php'));

        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Correct way to register middleware aliases in Laravel 11/12
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'super.admin' => \App\Http\Middleware\CheckSuperAdmin::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            '2fa' => \App\Http\Middleware\Ensure2FAEnabled::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'user.active' => \App\Http\Middleware\CheckUserStatus::class,
            'service.provider' => \App\Http\Middleware\CheckServiceProviderRole::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('promotions:expire')->everyMinute()->withoutOverlapping()->onOneServer();
    })->create();
