<?php

// app/Models/NotificationType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }
}
