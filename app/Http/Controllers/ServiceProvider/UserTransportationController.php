<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\UserTransportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransportationController extends Controller
{
    public function getTransportations()
    {
        $user = Auth::user();

        // Get or create with all false
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

        return response()->json([
            'success' => true,
            'data' => $transportation,
            'message' => 'Transportation settings retrieved successfully.',
        ]);
    }

    /**
     * Add/Update transportation settings
     * POST /api/transportations
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

        // Only update fields that are provided
        if ($request->has('bicycle')) {
            $data['bicycle'] = $request->bicycle;
        }

        if ($request->has('car')) {
            $data['car'] = $request->car;
        }

        if ($request->has('scooter')) {
            $data['scooter'] = $request->scooter;
        }

        if ($request->has('truck')) {
            $data['truck'] = $request->truck;
        }

        if ($request->has('walk')) {
            $data['walk'] = $request->walk;
        }

        // If no data provided, return error
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'No transportation settings provided for update.',
            ], 400);
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

        return response()->json([
            'success' => true,
            'data' => $transportation,
            'message' => 'Transportation settings updated successfully.',
        ]);
    }
}
