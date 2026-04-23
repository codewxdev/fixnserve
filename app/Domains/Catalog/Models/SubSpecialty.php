<?php

namespace App\Domains\Catalog\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SubSpecialty extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $fillable = ['specialty_id', 'name'];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
