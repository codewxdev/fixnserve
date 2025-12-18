<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('subcategories')->get();

        return ApiResponse::success($services, 'Services fetched successfully');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user->hasRole('service provider')) {
            return ApiResponse::error('Only service providers can create services.', 403);
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

        return ApiResponse::success($service->load('subcategories'), 'Service created successfully', 201);
    }

    public function show($id)
    {
        $service = Service::with('subcategories')->findOrFail($id);

        return ApiResponse::success($service, 'Service fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (! $user->hasRole('service provider')) {
            return ApiResponse::error('Only service providers can update services.', 403);
        }

        $service = Service::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'price_per_hour' => 'nullable|numeric',
            'fee' => 'nullable|numeric',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:subcategories,id',
        ]);

        $service->update($request->only(['price_per_hour', 'fee', 'description', 'category_id']));

        if ($request->has('subcategories')) {
            $service->subcategories()->sync($request->subcategories);
        }

        return ApiResponse::success($service->load('subcategories'), 'Service updated successfully');
    }

    public function destroy($id)
    {
        $deleted = Service::destroy($id);

        if ($deleted) {
            return ApiResponse::success(null, 'Service deleted successfully');
        }

        return ApiResponse::error('Service not found', 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $service = Service::findOrFail($id);
        $service->update(['status' => $request->status]);

        return ApiResponse::success($service, "Service status updated to {$request->status}");
    }
}
