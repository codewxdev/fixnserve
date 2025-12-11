<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Service::with('subcategories')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user->hasRole('service provider')) {
            return response()->json([
                'status' => false,
                'message' => 'Only service providers can create services.',
            ], 403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'price_per_hour' => 'required|numeric',
            'fee' => 'nullable|numeric',
            'description' => 'nullable|string',
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:subcategories,id',
        ]);

        $service = Service::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'price_per_hour' => $request->price_per_hour,
            'fee' => $request->fee,
            'description' => $request->description,
        ]);

        if ($request->has('subcategories')) {
            $service->subcategories()->sync($request->subcategories);
        }

        return response()->json([
            'status' => true,
            'message' => 'Service created successfully',
            'data' => $service->load('subcategories'),
        ], 201);
    }

    public function show($id)
    {
        $service = Service::with('subcategories')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $service,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        // Only service providers can update
        if (! $user->hasRole('service provider')) {
            return response()->json([
                'status' => false,
                'message' => 'Only service providers can update services.',
            ], 403);
        }

        // Check service ownership: user can update only their own services
        $service = Service::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'price_per_hour' => 'nullable|numeric',
            'fee' => 'nullable|numeric',
            'description' => 'nullable|string',
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:subcategories,id',
        ]);

        $service->update($request->only([
            'price_per_hour', 'fee', 'description', 'category_id',
        ]));

        if ($request->has('subcategories')) {
            $service->subcategories()->sync($request->subcategories);
        }

        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully',
            'data' => $service->load('subcategories'),
        ]);
    }

    public function destroy($id)
    {
        $deleted = Service::destroy($id);

        return response()->json([
            'status' => $deleted ? true : false,
            'message' => $deleted ? 'Service deleted' : 'Service not found',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
        $service = Service::findOrFail($id);
        $service->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Service status updated to {$request->status}",
            'data' => $service,
        ]);
    }
}
