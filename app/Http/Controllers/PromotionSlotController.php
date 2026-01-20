<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\PromotionSlot;
use App\Services\PromotionSlotService;
use Illuminate\Http\Request;

class PromotionSlotController extends Controller
{
    protected $slotService;

    public function __construct(PromotionSlotService $slotService)
    {
        $this->slotService = $slotService;
    }

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
            'max_slots' => 'required|integer|min:1',
            'visibility_weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $slot = $this->slotService->create($data);

        return ApiResponse::success($slot, 'Promotion slot created', 201);
    }

    public function update(Request $request, PromotionSlot $promotionSlot)
    {
        $slot = $this->slotService->update(
            $promotionSlot,
            $request->only(['max_slots', 'visibility_weight', 'price'])
        );

        return ApiResponse::success($slot, 'Promotion slot updated');
    }

    public function show($id)
    {
        $promotionSlot = PromotionSlot::find($id);
        if (! $promotionSlot) {
            return ApiResponse::error('Promotion slot not found', 404);
        }

        return ApiResponse::success(
            $promotionSlot->load('promotion')
        );
    }

    public function destroy(PromotionSlot $promotionSlot)
    {
        $this->slotService->delete($promotionSlot);

        return ApiResponse::success(null, 'Promotion slot deleted');
    }
}
