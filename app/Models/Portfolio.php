<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_title',
        'role',
        'description',
        'image',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'portfolio_skills');
    }
}
