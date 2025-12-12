<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * Get user's notification settings
     */
    public function getSettings()
    {
        $user = Auth::user();

        // Get or create notification settings for user
        $notification = UserNotification::firstOrCreate(
            ['user_id' => $user->id],
            [
                'email' => true,
                'sms' => false,
                'push' => false,
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $notification,
            'message' => 'Notification settings retrieved successfully.',
        ]);
    }

    /**
     * Simple function to set 1 or 0 for each field
     * Can be called directly from your application
     */
    /**
     * Set notification settings - user can update any combination of fields
     * This function allows user to update 1, 2, or all 3 fields as per their choice
     */
    public function setNotificationSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'sometimes|in:0,1,true,false', // sometimes = optional
            'sms' => 'sometimes|in:0,1,true,false',
            'push' => 'sometimes|in:0,1,true,false',
        ]);

        $data = [];

        // Only add fields that are present in the request
        if ($request->has('email')) {
            $data['email'] = filter_var($request->email, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('sms')) {
            $data['sms'] = filter_var($request->sms, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('push')) {
            $data['push'] = filter_var($request->push, FILTER_VALIDATE_BOOLEAN);
        }

        // Check if at least one field is being updated
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'No settings provided for update.',
            ], 400);
        }

        $notification = UserNotification::updateOrCreate(
            ['user_id' => $user->id],
            array_merge([
                'email' => true,  // Default values
                'sms' => false,
                'push' => false,
            ], $data) // Override with user's values
        );

        return response()->json([
            'success' => true,
            'data' => $notification,
            'message' => 'Notification settings updated successfully.',
        ]);
    }
}
