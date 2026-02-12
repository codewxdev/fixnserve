<?php

namespace App\Services;

use App\Models\KillSwitche;

class KillSwitchService
{
    public function active($scope)
    {
        return cache()->remember(
            "kill_switch:$scope", 10, fn () => KillSwitche::where('scope', $scope)
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
