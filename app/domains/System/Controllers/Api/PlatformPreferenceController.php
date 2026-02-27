<?php

namespace App\Domains\System\Controllers\Api;

use App\Domains\System\Services\PlatformPreferenceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlatformPreferenceController extends Controller
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

        return response()->json([
            'message' => 'Platform preferences updated',
            'version' => $result->version,
        ]);
    }

    public function current()
    {
        return Cache::get('platform_preferences');
    }
}
