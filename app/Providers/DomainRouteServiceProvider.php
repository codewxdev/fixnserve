<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class DomainRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadDomainRoutes();
    }

    protected function loadDomainRoutes(): void
    {
        // app/domains
        $domainsPath = app_path('domains');

        if (! File::isDirectory($domainsPath)) {
            return;
        }

        foreach (File::directories($domainsPath) as $domainPath) {

            // app/domains/ModuleXyz/routes
            $routesPath = $domainPath . '/routes';

            if (! File::isDirectory($routesPath)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Web Routes
            |--------------------------------------------------------------------------
            */
            if (File::exists($routesPath . '/web.php')) {
                Route::middleware('web')
                    ->group($routesPath . '/web.php');
            }

            /*
            |--------------------------------------------------------------------------
            | API Routes
            |--------------------------------------------------------------------------
            */
            if (File::exists($routesPath . '/api.php')) {
                Route::prefix('api')
                    ->middleware('api')
                    ->group($routesPath . '/api.php');
            }
        }
    }
}
