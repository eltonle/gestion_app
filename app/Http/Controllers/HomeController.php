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
        return view('home');
    }

    
    // ESSAI CHARJS
    public function getDatajs( $d)
    {
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($d == '7') {
            $startDate = now()->subDays(7)->startOfDay();
        }
        elseif ($d == '30') {
            $startDate = now()->subDays(30)->startOfDay();
        } elseif ($d == 'lastMonth') {
            $startDate = now()->subMonth()->startOfMonth();
            $endDate = now()->subMonth()->endOfMonth();
        }elseif ($d === 'thisMonth') {
            $startDate = now()->startOfMonth();
        } elseif ($d === 'thisYear') {
            $startDate = now()->startOfYear();
        } elseif ($d === 'lastYear') {
            $startDate = now()->subYear()->startOfYear();
            $endDate = now()->subYear()->endOfYear();
        }
        elseif ($d === 'day') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        }

        $data = DB::table('payments')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
        $payDetail = DB::table('payment_details')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
       
       
        return response()->json([$data,$payDetail]); // Retournez les données au format JSON
    }
}
