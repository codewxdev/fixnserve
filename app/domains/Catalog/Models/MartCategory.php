<?php

namespace App\Domains\Catalog\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MartCategory extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
