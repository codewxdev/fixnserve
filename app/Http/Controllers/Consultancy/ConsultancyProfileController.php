<?php

namespace App\Http\Controllers\Consultancy;

use App\Http\Controllers\Controller;
use App\Models\ConsultancyProfile;
use Illuminate\Http\Request;

class ConsultancyProfileController extends Controller
{
    public function show()
    {
        return ConsultancyProfile::where('user_id', auth()->id())->first();
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'currency_id' => 'nullable|exists:currencies,id',
            'fee_15' => 'nullable|numeric|min:0',
            'fee_30' => 'nullable|numeric|min:0',
            'fee_45' => 'nullable|numeric|min:0',
            'fee_60' => 'nullable|numeric|min:0',
            'is_online' => 'boolean',
        ]);

        $fee15 = $request->fee_15;

        // 🔹 Auto-calculate missing fees
        $fee30 = $request->fee_30 ?? ($fee15 ? $fee15 * 2 : null);
        $fee45 = $request->fee_45 ?? ($fee15 ? $fee15 * 3 : null);
        $fee60 = $request->fee_60 ?? ($fee15 ? $fee15 * 4 : null);

        // ❌ If nothing provided at all
        if (! $fee15 && ! $fee30 && ! $fee45 && ! $fee60) {
            return response()->json([
                'message' => 'At least one fee is required',
            ], 422);
        }

        $profile = ConsultancyProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'currency_id' => $request->currency_id ?? 1,
                'fee_15' => $fee15,
                'fee_30' => $fee30,
                'fee_45' => $fee45,
                'fee_60' => $fee60,
                'is_online' => $request->is_online ?? true,
            ]
        );

        return response()->json([
            'message' => 'Consultancy profile saved successfully',
            'data' => $profile,
        ]);
    }
}
