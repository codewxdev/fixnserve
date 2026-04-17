<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasTranslations;

    public array $translatable = ['device_name', 'os_version', 'app_version', 'trust_status'];

    protected $fillable = [
        'user_id',
        'device_name',
        'fingerprint',
        'os_version',
        'app_version',
        'last_ip',
        'trust_status',
        'last_seen_at',
        'is_rooted',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
