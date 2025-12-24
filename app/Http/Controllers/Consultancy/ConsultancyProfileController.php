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
            'fee_15' => 'nullable|numeric',
            'fee_30' => 'nullable|numeric',
            'fee_45' => 'nullable|numeric',
            'fee_60' => 'nullable|numeric',
            'is_online' => 'boolean',
        ]);

        $profile = ConsultancyProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'currency_id' => $request->currency_id ?? 1,
                'fee_15' => $request->fee_15,
                'fee_30' => $request->fee_30,
                'fee_45' => $request->fee_45,
                'fee_60' => $request->fee_60,
                'is_online' => $request->is_online ?? true,
            ]
        );

        return response()->json([
            'message' => 'Consultancy profile saved',
            'data' => $profile,
        ]);
    }
}
