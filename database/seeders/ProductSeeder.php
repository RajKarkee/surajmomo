<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Chicken Steamed Momo',
                'description' => 'Juicy chicken wrapped in soft dough with authentic spices, steamed to perfection',
                'price' => 250,
                'image_url' => 'https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=400&h=300&fit=crop',
                'category' => 'steamed',
                'status' => 'active',
                'ingredients' => 'Chicken, onions, garlic, ginger, cilantro, spices',
                'spice_level' => 'medium'
            ],
            [
                'name' => 'Vegetable Steamed Momo',
                'description' => 'Fresh vegetables and herbs in traditional steamed dumplings',
                'price' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop',
                'category' => 'steamed',
                'status' => 'active',
                'ingredients' => 'Cabbage, carrots, onions, garlic, ginger, cilantro',
                'spice_level' => 'mild'
            ],
            [
                'name' => 'Paneer Steamed Momo',
                'description' => 'Cottage cheese with aromatic spices in delicate wrappers',
                'price' => 280,
                'image_url' => 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&h=300&fit=crop',
                'category' => 'steamed',
                'status' => 'active',
                'ingredients' => 'Paneer, onions, bell peppers, garlic, ginger, spices',
                'spice_level' => 'mild'
            ],
            [
                'name' => 'Buff Steamed Momo',
                'description' => 'Traditional buffalo meat momos with authentic Nepali taste',
                'price' => 300,
                'image_url' => 'https://images.unsplash.com/photo-1563379091755-de3815efea9b?w=400&h=300&fit=crop',
                'category' => 'steamed',
                'status' => 'active',
                'ingredients' => 'Buffalo meat, onions, garlic, ginger, traditional spices',
                'spice_level' => 'spicy'
            ],
            [
                'name' => 'Chicken Fried Momo',
                'description' => 'Crispy fried chicken momos with golden exterior and juicy filling',
                'price' => 320,
                'image_url' => 'https://images.unsplash.com/photo-1606491956689-2ea866880c84?w=400&h=300&fit=crop',
                'category' => 'fried',
                'status' => 'active',
                'ingredients' => 'Chicken, onions, garlic, ginger, cilantro, chili',
                'spice_level' => 'spicy'
            ],
            [
                'name' => 'Mixed Veg Fried Momo',
                'description' => 'Assorted vegetables with mushrooms, crispy fried to perfection',
                'price' => 230,
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
                'category' => 'fried',
                'status' => 'active',
                'ingredients' => 'Mixed vegetables, mushrooms, tofu, herbs',
                'spice_level' => 'medium'
            ],
            [
                'name' => 'Chicken Pan-Fried Momo',
                'description' => 'Half-steamed, half-fried chicken momos with crispy bottom',
                'price' => 290,
                'image_url' => 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?w=400&h=300&fit=crop',
                'category' => 'pan-fried',
                'status' => 'active',
                'ingredients' => 'Chicken, onions, garlic, ginger, soy sauce',
                'spice_level' => 'medium'
            ],
            [
                'name' => 'Pork Special Momo',
                'description' => 'Premium pork momo with special herbs and spices',
                'price' => 350,
                'image_url' => 'https://images.unsplash.com/photo-1582169296194-0061a8c94a4f?w=400&h=300&fit=crop',
                'category' => 'special',
                'status' => 'active',
                'ingredients' => 'Pork, special herbs, garlic, ginger, wine',
                'spice_level' => 'spicy'
            ],
            [
                'name' => 'Cheese Corn Momo',
                'description' => 'Fusion momo with cheese and sweet corn filling',
                'price' => 270,
                'image_url' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=400&h=300&fit=crop',
                'category' => 'special',
                'status' => 'active',
                'ingredients' => 'Cheese, sweet corn, bell peppers, herbs',
                'spice_level' => 'mild'
            ],
            [
                'name' => 'Chocolate Momo',
                'description' => 'Sweet dessert momo filled with chocolate and nuts',
                'price' => 180,
                'image_url' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400&h=300&fit=crop',
                'category' => 'special',
                'status' => 'active',
                'ingredients' => 'Chocolate, nuts, butter, sugar',
                'spice_level' => null
            ],
            [
                'name' => 'Spinach Paneer Momo',
                'description' => 'Healthy spinach and paneer combination in steamed dumplings',
                'price' => 260,
                'image_url' => 'https://images.unsplash.com/photo-1589621316382-008455b857cd?w=400&h=300&fit=crop',
                'category' => 'steamed',
                'status' => 'active',
                'ingredients' => 'Spinach, paneer, onions, garlic, ginger',
                'spice_level' => 'mild'
            ],
            [
                'name' => 'Mutton Keema Momo',
                'description' => 'Minced mutton with rich spices in traditional style',
                'price' => 380,
                'image_url' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=400&h=300&fit=crop',
                'category' => 'special',
                'status' => 'active',
                'ingredients' => 'Mutton keema, onions, garlic, ginger, rich spices',
                'spice_level' => 'very_spicy'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
