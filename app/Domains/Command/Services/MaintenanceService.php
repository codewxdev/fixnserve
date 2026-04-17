<?php

namespace App\Domains\Command\Services;

use App\Domains\Command\Models\Maintenance;

class MaintenanceService
{
    public function activeMaintenances()
    {
        return cache()->remember(
            'maintenance:active',
            30,
            fn () => Maintenance::where('status', 'active')->get()
        );
    }

    public function global()
    {
        return $this->activeMaintenances()
            ->where('type', 'global')
            ->first();
    }

    public function module($module)
    {
        return $this->activeMaintenances()
            ->where('type', 'module')
            ->where('module', $module)
            ->first();
    }

    public function region($countryId)
    {
        return $this->activeMaintenances()
            ->where('type', 'region')
            ->where('country_id', $countryId)
            ->first();
    }
}
