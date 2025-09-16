<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jumbotron extends Model
{
    protected $fillable = [
        'page',
        'title',
        'subtitle',
        'background_image',
        'other_image'
    ];
}
