<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\NotificationType;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserNotificationController extends Controller
{
    /**
     * Get user's notification settings for all types
     */
    public function getUserNotificationSettings()
    {
        try {
            $user = Auth::user();

            // Get all notification types
            $notificationTypes = NotificationType::get();

            $userSettings = [];

            foreach ($notificationTypes as $type) {
                // Get or create user setting for this notification type
                $userNotification = UserNotification::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'notification_type_id' => $type->id,
                    ],
                    [
                        'email' => $type->default_channels['email'] ?? true,
                        'sms' => $type->default_channels['sms'] ?? false,
                        'push' => $type->default_channels['push'] ?? false,
                    ]
                );

                $userSettings[] = [
                    'notification_type' => $type,
                    'settings' => [
                        'id' => $userNotification->id,
                        'email' => (bool) $userNotification->email,
                        'sms' => (bool) $userNotification->sms,
                        'push' => (bool) $userNotification->push,
                    ],
                ];
            }

            return ApiResponse::success([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'notification_settings' => $userSettings,
            ], 'User notification settings retrieved successfully');

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve notification settings: '.$e->getMessage(), 500);
        }
    }

    /**
     * Update user's notification settings for a specific type
     */
    public function updateNotificationSettings(Request $request)
    {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'notification_type_id' => 'required|exists:notification_types,id',
                'email' => 'sometimes|boolean',
                'sms' => 'sometimes|boolean',
                'push' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error('Validation failed', 422, $validator->errors());
            }

            // Get notification type to access defaults if needed
            $notificationType = NotificationType::find($request->notification_type_id);

            $userNotification = UserNotification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'notification_type_id' => $request->notification_type_id,
                ],
                [
                    'email' => $request->has('email')
                        ? $request->boolean('email')
                        : ($notificationType->default_channels['email'] ?? true),
                    'sms' => $request->has('sms')
                        ? $request->boolean('sms')
                        : ($notificationType->default_channels['sms'] ?? false),
                    'push' => $request->has('push')
                        ? $request->boolean('push')
                        : ($notificationType->default_channels['push'] ?? false),
                ]
            );

            return ApiResponse::success([
                'settings' => $userNotification,
            ], 'Notification settings updated successfully');

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to update notification settings: '.$e->getMessage(), 500);
        }
    }

    /**
     * Reset user's notification settings to defaults for a specific type
     */
    public function resetToDefaults($notificationTypeId = null)
    {
        try {
            $user = Auth::user();

            if ($notificationTypeId) {
                // Reset specific notification type
                $notificationType = NotificationType::findOrFail($notificationTypeId);

                $userNotification = UserNotification::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'notification_type_id' => $notificationTypeId,
                    ],
                    [
                        'email' => $notificationType->default_channels['email'] ?? true,
                        'sms' => $notificationType->default_channels['sms'] ?? false,
                        'push' => $notificationType->default_channels['push'] ?? false,
                    ]
                );

                $message = 'Notification settings reset to defaults for '.$notificationType->name;
            } else {
                // Reset all notification types
                $notificationTypes = NotificationType::get();

                foreach ($notificationTypes as $type) {
                    UserNotification::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'notification_type_id' => $type->id,
                        ],
                        [
                            'email' => $type->default_channels['email'] ?? true,
                            'sms' => $type->default_channels['sms'] ?? false,
                            'push' => $type->default_channels['push'] ?? false,
                        ]
                    );
                }

                $message = 'All notification settings reset to defaults';
            }

            return ApiResponse::success(null, $message);

        } catch (\Exception $e) {
            return ApiResponse::error('Failed to reset settings: '.$e->getMessage(), 500);
        }
    }
}
