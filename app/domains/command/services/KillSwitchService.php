<?php

namespace App\Domains\Command\Services;

use App\Domains\Command\Models\KillSwitch;

class KillSwitchService
{
    public function active($scope)
    {
        return cache()->remember(
            "kill_switch:$scope", 10, fn () => KillSwitch::where('scope', $scope)
                ->where('status', 'active')
                ->first()
        );
    }

    public function isHardKilled($scope)
    {
        return optional($this->active($scope))->type === 'hard';
    }

    public function isSoftKilled($scope)
    {
        return optional($this->active($scope))->type === 'soft';
    }
}
