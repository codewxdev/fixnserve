<?php

namespace App\Domains\Catalog\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SubSpecialty extends Model
{
    protected $fillable = ['specialty_id', 'name'];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
