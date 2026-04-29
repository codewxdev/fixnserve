<?php

namespace App\Domains\System\Controllers\Cp\V1;

use App\Domains\System\Models\ReasonCode;
use App\Domains\System\Models\ReasonCodePolicy;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReasonCodeController extends BaseApiController
{
    // ✅ GET all codes + policy
    public function index()
    {
        $codes = ReasonCode::where('is_active', true)->paginate(10);
        $policy = ReasonCodePolicy::firstOrCreate(
            ['id' => 1],
            ['enforcement_level' => 'moderate']
        );

        return $this->success([
            'enforcement_level' => $policy->enforcement_level,
            'codes' => $codes,
        ], 'reason_codes_fetched');
    }

    // ✅ POST add new reason code
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255|unique:reason_codes,label',
        ]);

        $code = ReasonCode::create([
            'code' => Str::slug($validated['label'], '_'),
            'label' => $validated['label'],
        ]);

        return $this->success($code, 'reason_code_added', 201);
    }

    // ✅ DELETE reason code
    public function destroy(ReasonCode $reasonCode)
    {
        $reasonCode->update(['is_active' => false]);

        return $this->success(null, 'reason_code_removed');
    }

    // ✅ POST save policy
    public function savePolicy(Request $request)
    {
        $validated = $request->validate([
            'enforcement_level' => 'required|in:none,moderate,strict',
        ]);

        $policy = ReasonCodePolicy::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return $this->success($policy, 'policy_saved');
    }
}
