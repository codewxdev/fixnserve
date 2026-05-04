<?php

namespace App\Domains\System\Controllers\Cp\V1;

use App\Domains\System\Services\PlatformPreferenceService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlatformPreferenceController extends BaseApiController
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'rollout_mode' => 'required|in:immediate,scheduled',
        ]);

        $service = app(PlatformPreferenceService::class);

        $result = $service->update(
            $data['settings'],
            $data['rollout_mode']
        );

        return $this->success([
            'message' => 'Platform preferences updated',
            'version' => $result->version,
        ]);
    }

    public function current()
    {
        $service = Cache::get('platform_preferences');

        return $this->success($service);
    }
}
