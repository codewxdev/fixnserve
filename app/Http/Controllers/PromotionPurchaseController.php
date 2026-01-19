<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Promotion;
use App\Models\PromotionSlot;
use App\Services\PromotionPurchaseService;
use Exception;
use Illuminate\Http\Request;

class PromotionPurchaseController extends Controller
{
    public function store(Request $request, PromotionPurchaseService $service)
    {
        $validated = $request->validate([
            'app_id' => 'required|exists:apps,id',
            'promotion_id' => 'required|exists:promotions,id',
            'promotion_slot_id' => 'required|exists:promotion_slots,id',
            'payment_reference' => 'required|string',
        ]);

        try {
            $promotion = Promotion::findOrFail($validated['promotion_id']);
            $slot = PromotionSlot::findOrFail($validated['promotion_slot_id']);

            $purchase = $service->purchase(
                auth()->id(),
                $validated['app_id'],
                $promotion,
                $slot,
                $validated['payment_reference']
            );

            return ApiResponse::success($purchase, 'Promotion purchased successfully');

        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }
}
