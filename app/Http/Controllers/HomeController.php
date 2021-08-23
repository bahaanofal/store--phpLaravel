<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()
        ->limit(10)
        ->get();
        return view('home', compact('products'));
    }

    public function getUsersAddresses()
    {
        $users = User::with('profile')->get();
        foreach($users as $user)
        {
            echo $user->profile->address . '<br>';
        }
    }
}
