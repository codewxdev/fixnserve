<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\PromotionSlot;
use Illuminate\Http\Request;

class PromotionSlotController extends Controller
{
    public function index()
    {
        return ApiResponse::success(
            PromotionSlot::with('promotion')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'promotion_id' => 'required|exists:promotions,id',
            'app_id' => 'required|integer',
            'city_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'max_slots' => 'required|integer|min:1',
            'visibility_weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $slot = PromotionSlot::create($data);

        return ApiResponse::success($slot, 'Promotion slot created', 201);
    }

    public function update(Request $request, PromotionSlot $promotionSlot)
    {
        $promotionSlot->update($request->only([
            'max_slots',
            'visibility_weight',
            'price',
        ]));

        return ApiResponse::success($promotionSlot, 'Promotion slot updated');
    }

    public function destroy(PromotionSlot $promotionSlot)
    {
        $promotionSlot->delete();

        return ApiResponse::success(null, 'Promotion slot deleted');
    }
}
