<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use TJGazel\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\support\Facades\Hash;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-user | create-user | edit-user | delete-user', ['only'=>['index']]);
        $this->middleware('permission:create-user', ['only'=>['create','store']]);
        $this->middleware('permission:edit-user', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-user', ['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('frontend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  = Role::all();
        return view('frontend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // Validation Data
       $request->validate([
        'name' => 'required|max:50',
        'email' => 'required|max:100|email|unique:users',
        'password' => 'required|min:6|confirmed',
       ]);

        // Create New User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        Toastr::success('Utilisateur Creer avec success','Success');
        return redirect()->route('users.index');
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
        $user = User::find($id);
        $roles  = Role::all();
        return view('frontend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // Create New User
       $user = User::find($id);

       // Validation Data
       $request->validate([
           'name' => 'required|max:50',
           'email' => 'required|max:100|email|unique:users,email,' . $id,
           'password' => 'nullable|min:6|confirmed',
       ]);


       $user->name = $request->name;
       $user->email = $request->email;
       if ($request->password) {
           $user->password = Hash::make($request->password);
       }
       $user->save();

       $user->roles()->detach();
       if ($request->roles) {
           $user->assignRole($request->roles);
       }

       Toastr::success('Utilisateur mis à jour avec succès','Success');
       return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }

        Toastr::success('Utilisateur Supprimé ','Success');
        return redirect()->route('users.index');
    
    }
}
