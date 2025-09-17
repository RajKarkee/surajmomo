<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'what_we_do',
        'our_mission', 
        'our_story',
        'what_we_do_img',
        'our_story_img'
    ];

    protected $casts = [
        'what_we_do' => 'array',
        'our_mission' => 'array',
        'our_story' => 'array',
    ];
}
