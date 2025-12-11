<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $fillable = ['language', 'proficiency', 'user_id'];

    public function languages()
    {
        return $this->hasMany(UserLanguage::class);
    }
}
