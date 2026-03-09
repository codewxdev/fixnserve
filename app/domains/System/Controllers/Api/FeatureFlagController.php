<?php

namespace App\Domains\System\Controllers\Api;

use App\Domains\System\Models\FeatureFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureFlagController extends Controller
{
     
    public function index(Request $request)
    {
        $user = $request->user();
        $flags = FeatureFlag::all();

         
        $result = [];

        foreach ($flags as $flag) {
            $result[$flag->key] = FeatureFlag::isEnabled($flag->key, $user);
        }

        // dd($result);
        return response()->json([
            'success' => true,
            'data' => $flags,
        ]);
    }

    
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
