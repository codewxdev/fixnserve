<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    protected $fillable = ['user_id', 'skill_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills');
    }
}
