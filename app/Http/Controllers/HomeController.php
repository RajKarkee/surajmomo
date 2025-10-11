<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\offer;
use App\Models\Jumbotron;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function products()
    {
         $tz = 'Asia/Kathmandu';
    $now = \Carbon\Carbon::now($tz);
    
 
    $offers = Offer::whereDate('start_date', '<=', $now)
                   ->whereDate('end_date', '>=', $now)
                   ->get();
                   $jumbotron=Jumbotron::where('page','product')->first();
        return view('product', compact('offers','jumbotron'));
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
