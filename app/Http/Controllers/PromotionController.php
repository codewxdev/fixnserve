<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
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

        $promotion = Promotion::create($data);

        return ApiResponse::success($promotion, 'Promotion created', 201);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $promotion->update($request->only([
            'name',
            'duration_hours',
            'is_active',
        ]));

        return ApiResponse::success($promotion, 'Promotion updated');
    }

    public function show($id)
    {
        $promotion = Promotion::find($id);

        if (! $promotion) {
            return ApiResponse::error('Promotion not found', 404);
        }

        return ApiResponse::success($promotion);
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return ApiResponse::success(null, 'Promotion deleted');
    }
}
