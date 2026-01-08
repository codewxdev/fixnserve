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
    })->create();
