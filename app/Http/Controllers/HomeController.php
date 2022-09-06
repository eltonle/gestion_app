<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $hidden = Carbon::now();
        $nbr_user = DB::table('users')->count();
        $nbr_customer = Customer::whereDate('created_at', Carbon::today())->count();
        $sum_paid = Payment::whereDate('created_at', Carbon::today())->sum('paid_amount');
        $sum_due = Payment::whereDate('created_at', Carbon::today())->sum('due_amount');
        $sum_due = Payment::whereDate('created_at', Carbon::today())->sum('due_amount');
        $sum_versement = Payment::whereDate('created_at', Carbon::today())->sum('total_amount');
        $sum_discount = Payment::whereDate('created_at', Carbon::today())->sum('discount_amount');
      
        return view('home',compact('hidden','nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));
    }

    public function filter(Request $request)
    {
        
       $param = $request->search_id;
       if ($param == "7") {
           $dayselect = "7";
           $day = Carbon::now()->subDays($param);

           $nbr_user = DB::table('users')->count();
           $nbr_customer = Customer::whereDate('created_at', Carbon::today())->count();

           $sum_paid = Payment::where('created_at','>=', $day)->sum('paid_amount');
           $sum_due = Payment::whereDate('created_at','>=', $day)->sum('due_amount');
           $sum_versement = Payment::whereDate('created_at','>=', $day)->sum('total_amount');
           $sum_discount = Payment::whereDate('created_at','>=', $day)->sum('discount_amount');
         
           return view('viewserarch',compact('dayselect','nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));
        //    dd($sum_paid);
       }
       elseif ($param == "30") {
            
            $dayselect = "30";
            $day = Carbon::now()->subDays($param);

            $nbr_user = DB::table('users')->count();
            $nbr_customer = Customer::whereDate('created_at', Carbon::today())->count();

            $sum_paid = Payment::where('created_at','>=', $day)->sum('paid_amount');
            $sum_due = Payment::whereDate('created_at','>=', $day)->sum('due_amount');
            $sum_versement = Payment::whereDate('created_at','>=', $day)->sum('total_amount');
            $sum_discount = Payment::whereDate('created_at','>=', $day)->sum('discount_amount');
        
            return view('viewserarch',compact('dayselect','nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));
       }elseif ($param == "mois_dernier") {

            $dayselect = "mois_dernier";
            $nbr_user = DB::table('users')->count();
            $nbr_customer = Customer::whereDate('created_at', Carbon::today())->count(); 

            $sum_paid = Payment::select('*')
                                ->whereBetween('created_at',[Carbon::now()->subMonth()
                                ->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                                ->sum('paid_amount');
                                // dd($sum_paid);
            $sum_due = Payment::select('*')
                                ->whereBetween('created_at',[Carbon::now()->subMonth()
                                ->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                                ->sum('due_amount');                    
            
           $sum_versement = Payment::select('*')
                                ->whereBetween('created_at',[Carbon::now()->subMonth()
                                ->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                                ->sum('total_amount');    
                                
           $sum_discount = Payment::select('*')
                                ->whereBetween('created_at',[Carbon::now()->subMonth()
                                ->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
                                ->sum('discount_amount');                  

            return view('viewserarch',compact('dayselect','nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));                    
       }elseif ($param == "ce_mois") {

          $dayselect = "ce_mois";
          $nbr_user = DB::table('users')->count();
          $nbr_customer = Customer::whereDate('created_at', Carbon::today())->count(); 

          $sum_paid = Payment::whereMonth('created_at', Carbon::now()->month)
                                    ->sum('paid_amount');
                                    // dd($sum_paid);
         $sum_due = Payment::whereMonth('created_at', Carbon::now()->month)
                                    ->sum('due_amount');                    
                
        $sum_versement = Payment::whereMonth('created_at', Carbon::now()->month)
                                    ->sum('total_amount');    
                                    
         $sum_discount = Payment::whereMonth('created_at', Carbon::now()->month)
                                    ->sum('discount_amount');

                                    return view('viewserarch',compact('dayselect','nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));                         
       }elseif ($param == "aujourdhui") {
        // dd('ok');
        $dayselect = "aujourdhui";
        $nbr_user = DB::table('users')->count();
        $nbr_customer = Customer::whereDate('created_at', Carbon::today())->count();
        $sum_paid = Payment::whereDate('created_at', Carbon::today())->sum('paid_amount');
        $sum_due = Payment::whereDate('created_at', Carbon::today())->sum('due_amount');
        $sum_due = Payment::whereDate('created_at', Carbon::today())->sum('due_amount');
        $sum_versement = Payment::whereDate('created_at', Carbon::today())->sum('total_amount');
        $sum_discount = Payment::whereDate('created_at', Carbon::today())->sum('discount_amount');
      
        return view('viewserarch',compact('dayselect','nbr_user','nbr_customer','sum_paid','sum_due','sum_discount','sum_versement'));
       }
    }

}
