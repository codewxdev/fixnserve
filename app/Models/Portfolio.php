<?php

namespace App\Models;

use App\Domains\Catalog\Admin\Models\Skill;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['project_title',
        'role',
        'description'];

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
