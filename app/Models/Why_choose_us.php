<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Why_choose_us extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'image',
        'tagline'
    ];

    protected $table = 'why_choose_uses';
}
