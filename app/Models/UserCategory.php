<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    protected $fillable = ['user_id', 'category_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
