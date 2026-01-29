<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['order_id'];

    // public function messages()
    // {
    //     return $this->hasMany(ChatMessage::class);
    // }
}
