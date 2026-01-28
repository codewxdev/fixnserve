<?php

namespace App\Http\Controllers;

use App\Models\RiderVehicle;
use Illuminate\Http\Request;

class RiderVehicleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'transport_type_id' => 'required|exists:transport_types,id',
            'vehicle_number' => 'nullable|string',
            'vehicle_image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('vehicle_image')) {
            $imagePath = $request->file('vehicle_image')->store('vehicles', 'public');
        }

        $vehicle = RiderVehicle::create([
            'rider_id' => auth()->id(),
            'transport_type_id' => $request->transport_type_id,
            'vehicle_number' => $request->vehicle_number,
            'vehicle_image' => $imagePath,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'data' => $vehicle
        ], 201);
    }


}
