<?php

namespace App\Http\Controllers\Backend;

use App\Models\Unit;
use Illuminate\Http\Request;
use TJGazel\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\UnitRequest;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $units = Unit::all();
       return view('frontend.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
          $unit = new Unit();
          $unit -> name = $request->name;
          $unit -> created_by = Auth::user()->id;
          if ($unit ->save()) {
            Toastr::success('Unité Crée ','Success');
          }   
          return redirect()->route('units.index');
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
        $unit = Unit::find($id);
        return view('frontend.units.edit',compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        $unit = Unit::find($id);
        $unit -> name = $request->name;
        $unit -> updated_by = Auth::user()->id;
        
       if ($unit ->save()) {
         Toastr::success('Unité mise a jour ','Success');
        }   
      return redirect()->route('units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $unit = Unit::find($id); 

        if ($unit->delete()) {
            Toastr::success('Unité supprimée','Success');
           }   
         return redirect()->route('units.index');
    }
}
