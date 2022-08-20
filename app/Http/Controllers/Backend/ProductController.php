<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use TJGazel\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-product | create-product | edit-product | delete-product', ['only'=>['index']]);
        $this->middleware('permission:create-product', ['only'=>['create','store']]);
        $this->middleware('permission:edit-product', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-product', ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('frontend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('frontend.products.create', compact('categories','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
       $product = new Product();
       $product->name = $request->name;
       $product->category_id = $request->category_id;
       $product->unit_id = $request->unit_id;
       $product->created_by = Auth::user()->id;
      
        if ($product->save()) {
            Toastr::success('Clothe created successfully','Success');
            return redirect()->route('products.index');
        }else {
            Toastr::error('Clothe cannot be created successfully','Error');
            return redirect()->back();
        }
 
        return to_route('products.index');
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $product = Product::find($id);
        $categories = Category::all();
        $units = Unit::all();
        return view('frontend.products.edit', compact('categories','units','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product-> unit_id = $request->unit_id;
        $product->updated_by = Auth::user()->id;

        $product->save();
       Toastr::success('Clothe UPDATE successfully','Success');
       return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
    
        if ($product->delete()) {
            Toastr::success('Product DELETE successfully','Success');
        }
        
        return to_route('products.index');
    }
}
