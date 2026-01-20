<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Promotion;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function __construct(
        protected PromotionService $promotionService
    ) {}

    public function index()
    {
        return ApiResponse::success(
            Promotion::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'app_id' => 'required|integer',
            'name' => 'required|string',
            'duration_hours' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $promotion = $this->promotionService->create($data);

        return ApiResponse::success($promotion, 'Promotion created', 201);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $promotion = $this->promotionService->update(
            $promotion,
            $request->only(['name', 'duration_hours', 'is_active'])
        );

        return ApiResponse::success($promotion, 'Promotion updated');
    }

    public function destroy(Promotion $promotion)
    {
        $this->promotionService->delete($promotion);

        return ApiResponse::success(null, 'Promotion deleted');
    }

    public function show($id)
    {
        $promotion = Promotion::find($id);

        if (! $promotion) {
            return ApiResponse::notFound('Promotion not found');
        }

        return ApiResponse::success($promotion);
    }
}
