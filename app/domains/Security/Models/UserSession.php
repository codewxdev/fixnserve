<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'jwt_id',
        'token',
        'device',
        'ip_address',
        'location',
        'risk_score',
        'last_activity_at',
        'expires_at',
        'revoked_at',
        'logout_at',
        'is_revoked',
        'device_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'logout_at' => 'datetime',
        'is_revoked' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
