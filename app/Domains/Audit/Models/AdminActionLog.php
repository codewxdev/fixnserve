<?php

namespace App\Domains\Audit\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AdminActionLog extends Model
{
    use HasTranslations;

    public array $translatable = ['reason_code'];

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'before_state' => 'array',
        'after_state' => 'array',
        'performed_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updating(fn () => false);
        static::deleting(fn () => false);
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'performed_by');
    }
}
