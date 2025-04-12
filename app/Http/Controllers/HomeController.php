<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['variants.color', 'variants.size'])
            ->where('onpage', 1)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        return view('home', compact('products'));
    }
}