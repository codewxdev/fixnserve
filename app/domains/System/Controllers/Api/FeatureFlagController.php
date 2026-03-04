<?php

namespace App\Domains\System\Controllers\Api;

use App\Domains\System\Models\FeatureFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureFlagController extends Controller
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

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Feature flag created',
            'data' => $flag,
        ]);
    }

    // 3️⃣ Update flag (Enable/Disable / Rollout change)
    public function update(Request $request, FeatureFlag $flag)
    {
        $flag->update($request->only('type', 'value'));

        return response()->json([
            'success' => true,
            'message' => 'Feature flag updated',
            'data' => $flag,
        ]);
    }
}
