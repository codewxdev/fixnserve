<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'boost_weight',
        'promo_active',
        'promo_expires_at',
    ];
}
