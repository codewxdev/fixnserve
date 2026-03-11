<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasTranslations;

    public array $translatable = ['review',
    ];

    protected $fillable = [
        'user_id',
        'rateable_id',
        'rateable_type',
        'rating',
        'review',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
