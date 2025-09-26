<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function home(){
        $products = Product::where('status', 'active')->orderBy('sort_order', 'ASC')->get();
        return view('home', compact('products'));
    }

    public function about(){
        return view('about');
    }

    public function product(){
        return view('product');
    }
}
