<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
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

        $notification = UserNotification::firstOrCreate(
            ['user_id' => $user->id],
            [
                'email' => true,
                'sms' => false,
                'push' => false,
            ]
        );

        return ApiResponse::success($notification, 'Notification settings retrieved successfully');
    }

    /**
     * Set notification settings - user can update any combination of fields
     */
    public function setNotificationSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'sometimes|in:0,1,true,false',
            'sms' => 'sometimes|in:0,1,true,false',
            'push' => 'sometimes|in:0,1,true,false',
        ]);

        $data = [];

        if ($request->has('email')) {
            $data['email'] = filter_var($request->email, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('sms')) {
            $data['sms'] = filter_var($request->sms, FILTER_VALIDATE_BOOLEAN);
        }

        if ($request->has('push')) {
            $data['push'] = filter_var($request->push, FILTER_VALIDATE_BOOLEAN);
        }

        if (empty($data)) {
            return ApiResponse::error('No settings provided for update.', 400);
        }

        $notification = UserNotification::updateOrCreate(
            ['user_id' => $user->id],
            array_merge([
                'email' => true,
                'sms' => false,
                'push' => false,
            ], $data)
        );

        return ApiResponse::success($notification, 'Notification settings updated successfully');
    }
}
