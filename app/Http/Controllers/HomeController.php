<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function products()
    {
        return view('product');
    }

    public function about()
    {
        return view('about');
    }

    public function productSingle()
    {
        
        return view('productSingle');
    }
    public function orderConfirmation()
    {
        return view('orderConfirm');
    }
}
