<?php

namespace App\Domains\System\Controllers\Api;

use App\Domains\System\Models\FeatureFlag;
use App\Domains\System\Models\FeatureFlagLog;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class FeatureFlagController extends BaseApiController
{
    // 1️⃣ Get all enabled flags for logged in user
    public function index(Request $request)
    {
        $user = $request->user();
        $flags = FeatureFlag::all();

        $result = [];

        foreach ($flags as $flag) {
            $result[$flag->key] = FeatureFlag::isEnabled($flag->key, $user);
        }
        if (empty($result)) {
            return $this->notFound('No feature flags found');
        }

        return $this->success($result);
    }

    // 2️⃣ Create new feature flag
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:feature_flags,key',
            'type' => 'required|in:boolean,percentage,user_segment',
            'value' => 'nullable|array',
        ]);

        $flag = FeatureFlag::create($request->only('key', 'type', 'value'));
        FeatureFlagLog::create([
            'feature_flag_id' => $flag->id,
            'changed_by' => $request->user()->id,
            'old_value' => null,
            'new_value' => $flag->value,
        ]);

        return $this->success($flag, 'Feature flag created', 201);
    }

    // 3️⃣ Update flag (Enable/Disable / Rollout change)
    public function update(Request $request, FeatureFlag $flag)
    {
        $flag->update($request->only('type', 'value'));

        FeatureFlagLog::create([
            'feature_flag_id' => $flag->id,
            'changed_by' => $request->user()->id,
            'old_value' => $flag->getOriginal('value'),
            'new_value' => $flag->value,
        ]);

        return $this->success($flag, 'Feature flag updated');
    }

    // 4️⃣ Delete flag
    public function destroy(Request $request, FeatureFlag $flag)
    {
        FeatureFlagLog::create([
            'feature_flag_id' => $flag->id,
            'changed_by' => $request->user()->id,
            'old_value' => $flag->value,
            'new_value' => null,
        ]);
        $flag->delete();

        return $this->success([], 'Feature flag deleted');
    }
}
