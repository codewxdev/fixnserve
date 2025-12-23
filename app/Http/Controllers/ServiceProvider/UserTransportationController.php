<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\UserTransportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransportationController extends Controller
{
    /**
     * Get user's transportation settings
     */
    public function getTransportations()
    {
        $user = Auth::user();

        // Get or create with default false
        $transportation = UserTransportation::firstOrCreate(
            ['user_id' => $user->id],
            [
                'bicycle' => false,
                'car' => false,
                'scooter' => false,
                'truck' => false,
                'walk' => false,
            ]
        );

        return ApiResponse::success($transportation, 'Transportation settings retrieved successfully');
    }

    /**
     * Add/Update transportation settings
     * User can update any combination of fields
     */
    public function updateTransportations(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'bicycle' => 'sometimes|boolean',
            'car' => 'sometimes|boolean',
            'scooter' => 'sometimes|boolean',
            'truck' => 'sometimes|boolean',
            'walk' => 'sometimes|boolean',
        ]);

        $data = [];

        foreach (['bicycle', 'car', 'scooter', 'truck', 'walk'] as $field) {
            if ($request->has($field)) {
                $data[$field] = $request->$field;
            }
        }

        if (empty($data)) {
            return ApiResponse::error('No transportation settings provided for update.', 400);
        }

        // Update or create transportation settings
        $transportation = UserTransportation::updateOrCreate(
            ['user_id' => $user->id],
            array_merge([
                'bicycle' => false,
                'car' => false,
                'scooter' => false,
                'truck' => false,
                'walk' => false,
            ], $data)
        );

        return ApiResponse::success($transportation, 'Transportation settings updated successfully');
    }
}
