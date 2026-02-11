<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso2',
        'phone_code',
        'flag_url',
        'phone_length',
        'status',

    ];

    protected $hidden = ['created_at', 'updated_at'];
}
