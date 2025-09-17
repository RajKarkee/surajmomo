<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class What_our_customer_say extends Model
{
    protected $table = 'what_our_customer_says';
    
    protected $fillable = [
        'customer_name',
        'customer_work',
        'feedback',
        'customer_image',
        'rating'
    ];
}
