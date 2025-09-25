<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'category',
        'status',
        'sort_order',
        'ingredients',
        'spice_level'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
