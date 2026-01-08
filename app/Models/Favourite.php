<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $fillable = [
        'user_id',
        'favouritable_id',
        'favouritable_type',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function favouritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
