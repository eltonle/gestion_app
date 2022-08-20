<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class VetementController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('frontend.vetements.index',compact('products'));
    }
}
