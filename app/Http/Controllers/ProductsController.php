<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
  

    public function index()
    {
        // $products = Product::active()->price(200, 500)->paginate();
        $products = Product::active()->paginate();
        return view('front.products.index', compact('products'));
    }
    
    public function show($slug)
    {
        $product = Product::where('slug', '=', $slug)->firstOrFail();
        return view('front.products.show', [
            'product' => $product,
        ]);
    }


}
