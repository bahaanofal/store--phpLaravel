<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
  

    public function index()
    {
        return Product::active()->price(200, 500)->paginate();
    }
    
    public function show($id)
    {
        return Product::findOrFail($id);
    }


}
