<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_email',
        'order_type',
        'business_name',
        'address',
        'phone',
        'map_coordinates',
        'cart',
        'total',
        'ordered_at',
    ];

    protected $casts = [
        'cart' => 'array',
        'ordered_at' => 'datetime',
    ];
}
