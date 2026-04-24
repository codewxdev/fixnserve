<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class DomainRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadDomainRoutes();
    }

    protected function loadDomainRoutes(): void
    {
        // app/domains
        $domainsPath = app_path('Domains');

        if (! File::isDirectory($domainsPath)) {
            return;
        }

        foreach (File::directories($domainsPath) as $domainPath) {

            // app/domains/ModuleXyz/routes
            $routesPath = $domainPath.'/Routes';

            if (! File::isDirectory($routesPath)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Web Routes
            |--------------------------------------------------------------------------
            */
            if (File::exists($routesPath.'/web.php')) {
                Route::middleware('web')
                    ->group($routesPath.'/web.php');
            }

            /*
            |--------------------------------------------------------------------------
            | API Routes
            |--------------------------------------------------------------------------
            */
            if (File::exists($routesPath.'/api-v1.php')) {
                Route::prefix('api/v1')
                    ->middleware('api')
                    ->group($routesPath.'/api-v1.php');
            }
            if (File::exists($routesPath.'/sys-v1.php')) {
                Route::prefix('sys/v1')
                    ->middleware('api')
                    ->group($routesPath.'/sys-v1.php');
            }
            if (File::exists($routesPath.'/cp-v1.php')) {
                Route::prefix('cp/v1')
                    ->middleware('api')
                    ->group($routesPath.'/cp-v1.php');
            }
        }
    }
}
