<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\UserCategory;
use App\Models\UserSubcategory;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function saveCategoriesAndSubcategories(Request $request)
    {
        $user = auth()->user(); // Logged in user

        // ----------------------------
        // Role check: must be service_provider
        // ----------------------------
        if (! $user->hasRole('service provider')) {
            return response()->json([
                'status' => false,
                'message' => 'Only service providers can save categories and subcategories.',
            ], 403);
        }

        // ----------------------------
        // Validation
        // ----------------------------
        $request->validate([
            'categories' => 'required|array|max:5', // max 5 categories
            'subcategories' => 'nullable|array',
        ]);

        $userId = $user->id;

        // ----------------------------
        // Validate each category has max 3 subcategories
        // ----------------------------
        $grouped = collect($request->subcategories)->groupBy('category_id');

        foreach ($grouped as $catId => $subs) {
            if ($subs->count() > 3) {
                return response()->json([
                    'status' => false,
                    'message' => "Category ID $catId can only have 3 subcategories selected.",
                ], 422);
            }
        }

        // ----------------------------
        // Save categories
        // ----------------------------
        UserCategory::where('user_id', $userId)->delete();

        foreach ($request->categories as $catId) {
            UserCategory::create([
                'user_id' => $userId,
                'category_id' => $catId,
            ]);
        }

        // ----------------------------
        // Save subcategories
        // ----------------------------
        UserSubcategory::where('user_id', $userId)->delete();

        if ($request->has('subcategories')) {
            foreach ($request->subcategories as $sub) {
                if (in_array($sub['category_id'], $request->categories)) {
                    UserSubcategory::create([
                        'user_id' => $userId,
                        'category_id' => $sub['category_id'],
                        'subcategory_id' => $sub['subcategory_id'],
                    ]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Categories and subcategories saved successfully',
        ], 200);
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'status' => 'sometimes|in:deleted,deactive',
        ]);

        if ($request->has('status')) {
            $user->status = $request->status;
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Account Status updated successfully',
            'data' => "Status is $user->status",
        ], 200);
    }

    public function updateMode(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'mode' => 'required|boolean', // یا 'required|in:0,1'
        ]);

        $user->update([
            'mode' => $request->mode,
        ]);

        $modeText = $user->mode ? 'Online' : 'Offline';

        return response()->json([
            'status' => true,
            'message' => 'Account mode updated successfully',
            'data' => [
                'mode' => $user->mode,
                'mode_text' => $modeText,
            ],
        ], 200);
    }
}
