<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function rate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:user,service',
            'id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $authUser = auth()->user();

        $map = [
            'user' => \App\Models\User::class,
            'service' => \App\Models\Service::class,
        ];

        $modelClass = $map[$request->type];

        // ❌ Cannot rate yourself
        if ($request->type === 'user' && $request->id == $authUser->id) {
            return ApiResponse::error(
                'You cannot rate yourself',
                422
            );
        }

        // ❌ Target not found
        if (! $modelClass::where('id', $request->id)->exists()) {
            return ApiResponse::notFound(
                ucfirst($request->type).' not found'
            );
        }

        // 🔁 Update or create rating
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $authUser->id,
                'rateable_id' => $request->id,
                'rateable_type' => $modelClass,
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return ApiResponse::success(
            $rating,
            'Rating saved successfully'
        );
    }
}
