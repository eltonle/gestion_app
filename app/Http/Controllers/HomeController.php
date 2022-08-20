<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nbr_user = DB::table('users')->count();
        $nbr_customer = DB::table('customers')->count();
        $sum_paid = Payment::sum('paid_amount');
        $sum_due = Payment::sum('due_amount');
        $sum_due = Payment::sum('due_amount');
        $sum_versement = Payment::sum('total_amount');
        $sum_discount = Payment::sum('discount_amount');
        // dd($sum_paid);
        // Product::where('id',$id)->sum('quantity');
        // dd($nbr);
        return view('home',compact('nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));
    }
}
