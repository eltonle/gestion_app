<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function getProduct(Request $request)
    {
        $category_id = $request->category_id;
        $product = Product::where('category_id', $category_id)->get();
        // dd($product->toArray());
        return response()->json($product);
    }
}
