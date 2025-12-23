<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubcategory extends Model
{
    protected $fillable = ['user_id', 'category_id', 'subcategory_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
