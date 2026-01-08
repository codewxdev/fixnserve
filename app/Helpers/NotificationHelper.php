<?php

// app/Helpers/NotificationHelper.php

namespace App\Helpers;

use App\Models\NotificationType;
use App\Models\User;
use App\Models\UserNotification;
use Exception;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    /**
     * Send notification to user based on their preferences
     */
    public static function sendToUser(User $user, string $typeSlug, array $data, array $channels = []): array
    {
        $results = [
            'success' => [],
            'failed' => [],
        ];

        // Get user's notification settings for this type
        $notificationSetting = $user->getNotificationSettings($typeSlug);

        // If no setting exists, create default ones
        if (! $notificationSetting) {
            $user->createDefaultNotificationSettings();
            $notificationSetting = $user->getNotificationSettings($typeSlug);
        }

        // Get notification type
        $notificationType = NotificationType::where('slug', $typeSlug)->first();

        if (! $notificationType) {
            throw new Exception("Notification type '{$typeSlug}' not found");
        }

        // Determine which channels to use
        $channelsToUse = ! empty($channels)
            ? $channels
            : self::getEnabledChannels($notificationSetting);

        // Send notifications via enabled channels
        foreach ($channelsToUse as $channel) {
            try {
                $method = 'send'.ucfirst($channel);

                if (method_exists(self::class, $method)) {
                    $result = self::$method($user, $data, $notificationType);

                    if ($result) {
                        $results['success'][$channel] = $result;

                        // Log successful notification
                        self::logNotification($user, $typeSlug, $channel, $data, true);
                    } else {
                        $results['failed'][$channel] = "Failed to send via {$channel}";

                        // Log failed notification
                        self::logNotification($user, $typeSlug, $channel, $data, false);
                    }
                }
            } catch (Exception $e) {
                $results['failed'][$channel] = $e->getMessage();

                // Log error
                Log::error("Notification failed for user {$user->id} via {$channel}: ".$e->getMessage());

                // Log failed notification
                self::logNotification($user, $typeSlug, $channel, $data, false, $e->getMessage());
            }
        }

        return $results;
    }

    /**
     * Send notification to multiple users
     */
    public static function sendToMultipleUsers(array $users, string $typeSlug, array $data, array $channels = []): array
    {
        $results = [
            'total_users' => count($users),
            'successful' => 0,
            'failed' => 0,
            'details' => [],
        ];

        foreach ($users as $user) {
            try {
                $userResult = self::sendToUser($user, $typeSlug, $data, $channels);

                if (! empty($userResult['success'])) {
                    $results['successful']++;
                    $results['details'][$user->id] = [
                        'status' => 'success',
                        'channels' => array_keys($userResult['success']),
                    ];
                } else {
                    $results['failed']++;
                    $results['details'][$user->id] = [
                        'status' => 'failed',
                        'errors' => $userResult['failed'],
                    ];
                }
            } catch (Exception $e) {
                $results['failed']++;
                $results['details'][$user->id] = [
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * Get enabled channels from user notification settings
     */
    private static function getEnabledChannels(UserNotification $setting): array
    {
        $channels = [];

        if ($setting->email) {
            $channels[] = 'email';
        }
        if ($setting->sms) {
            $channels[] = 'sms';
        }
        if ($setting->push) {
            $channels[] = 'push';
        }

        return $channels;
    }

    /**
     * Log notification activity
     */
    private static function logNotification(
        User $user,
        string $type,
        string $channel,
        array $data,
        bool $success,
        ?string $error = null
    ): void {
        // You can log to database, file, or monitoring service

        $logData = [
            'user_id' => $user->id,
            'type' => $type,
            'channel' => $channel,
            'success' => $success,
            'data' => json_encode($data),
            'error' => $error,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ];

        // Log to database table (you need to create this table)
        // DB::table('notification_logs')->insert($logData);

        // Or log to Laravel log file
        $level = $success ? 'info' : 'error';
        $message = $success
            ? "Notification sent to user {$user->id} via {$channel}"
            : "Notification failed for user {$user->id} via {$channel}: {$error}";

        Log::$level($message, $logData);
    }

    /**
     * Check if user has specific notification channel enabled
     */
    public static function isChannelEnabled(User $user, string $typeSlug, string $channel): bool
    {
        $setting = $user->getNotificationSettings($typeSlug);

        if (! $setting) {
            return false;
        }

        return match ($channel) {
            'email' => $setting->email,
            'sms' => $setting->sms,
            'push' => $setting->push,
            default => false,
        };
    }

    /**
     * Update user's notification preferences
     */
    public static function updateUserPreferences(User $user, string $typeSlug, array $channels): bool
    {
        try {
            $type = NotificationType::where('slug', $typeSlug)->first();

            if (! $type) {
                throw new Exception('Notification type not found');
            }

            $user->notificationSettings()->updateOrCreate(
                ['notification_type_id' => $type->id],
                [
                    'email' => in_array('email', $channels),
                    'sms' => in_array('sms', $channels),
                    'push' => in_array('push', $channels),
                ]
            );

            return true;
        } catch (Exception $e) {
            Log::error('Failed to update notification preferences: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Get notification statistics
     *
     * @param  string|null  $timeframe
     */
    public static function getStatistics(User $user, ?string $typeSlug = null, string $timeframe = '30days'): array
    {
        // Implement logic to get notification statistics
        // This could query your notification_logs table

        return [
            'total_sent' => 0,
            'total_failed' => 0,
            'success_rate' => 0,
            'by_channel' => [],
            'by_type' => [],
        ];
    }
}
