<?php

namespace App\Domains\RBAC\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['name', 'guard_name'];
}
