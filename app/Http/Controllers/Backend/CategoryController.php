<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use TJGazel\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-category | create-category | edit-category | delete-category', ['only'=>['index']]);
        $this->middleware('permission:create-category', ['only'=>['create','store']]);
        $this->middleware('permission:edit-category', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-category', ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('frontend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
         $category = new Category();
          $category -> name = $request->name;
          $category -> created_by = Auth::user()->id;
          if ($category ->save()) {
            Toastr::success('Categories créer avec succès','Success');
          }   
          return redirect()->route('categories.index');}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
       return view('frontend.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('frontend.categories.edit',compact('category'));}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    { 
        $category = Category::find($id);
       $category -> name = $request->name;
       $category -> updated_by = Auth::user()->id;
        
       if ($category ->save()) {
         Toastr::success('Catégorie mis à jour avec succès','Success');
        }   
      return redirect()->route('categories.index');}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $category = Category::find($id); 
        $category->products()->delete();
        if ($category->delete()) {
            Toastr::success('Catégorie supprimer avec succès','Success');
           }   
         return redirect()->route('categories.index');}
}
