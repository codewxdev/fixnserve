<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_type_id',
        'email',
        'sms',
        'push',
    ];

    protected $casts = [
        'email' => 'boolean',
        'sms' => 'boolean',
        'push' => 'boolean',
    ];

    /**
     * Get the user that owns the notification settings.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    // Scope to get settings for specific type
    public function scopeOfType($query, $typeSlug)
    {
        return $query->whereHas('notificationType', function ($q) use ($typeSlug) {
            $q->where('slug', $typeSlug);
        });
    }
}
