<?php

namespace App\Http\Controllers\Backend;

use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use TJGazel\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Models\PaymentDetail;
use PDF; 
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $customers = Customer::all();
       return view('frontend.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
          $customer = new Customer();
          $customer -> name = $request->name;
          $customer -> email = $request->email;
          $customer -> mobile_no = $request->mobile_no;
          $customer -> address = $request->address;
          $customer -> created_by = Auth::user()->id;
          if ($customer ->save()) {
            Toastr::success('Client créer avec succès','Success');
          }   
          return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('frontend.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {

       $customer = Customer::find($id);
       $customer -> name = $request->name;
       $customer -> email = $request->email;
       $customer -> mobile_no = $request->mobile_no;
       $customer -> address = $request->address;
       $customer -> updated_by = Auth::user()->id;
        
       if ($customer ->save()) {
         Toastr::success('Client mise a jpur avec succès','Success');
        }   
      return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id); 

        if ($customer->delete()) {
            Toastr::success('Client supprimer avec succès','Success');
           }   
         return redirect()->route('customers.index');
    }
  
    // DETTE OU CREDIT
    public function creditcustomer()
    {
      $data = Payment::whereIn('paid_status', ['full_due','partial_paid'])->get();
    
      return view('frontend.customers.credit',compact('data'));
    }

    public function creditcustomerpdf()
    {
      $data['data'] = Payment::whereIn('paid_status', ['full_due','partial_paid'])->get();
      $pdf = PDF::loadView('frontend.pdf.customer-credit-pdf', $data);
      $pdf->SetProtection(['copy','print'], '', 'pass');
      return $pdf->stream('document.pdf');
    }
    // PAYMENT DETTE
    public function paidcustomer()
    {
      $data = Payment::where('paid_status','!=', 'full_due')->get();
    
      return view('frontend.customers.paid',compact('data'));
    }

    public function paidcustomerpdf()
    {
      $data['data'] = Payment::where('paid_status','!=', 'full_due')->get();
      $pdf = PDF::loadView('frontend.pdf.customer-paid-pdf', $data);
      $pdf->SetProtection(['copy','print'], '', 'pass');
      return $pdf->stream('document.pdf'); 
    }

    // REPORT CUSTOMER WISE

    public function wiseReport()
    {
       $customers = Customer::all();
      return view('frontend.customers.wise-report',compact('customers'));
    }

    // credit customer
   
    public function wiseCredit(Request $request)
    {
      $data['data'] = Payment::where('customer_id',$request->customer_id)->whereIn('paid_status', ['full_due','partial_paid'])->get();
      $pdf = PDF::loadView('frontend.pdf.customer-wise-credit-pdf', $data);
      $pdf->SetProtection(['copy','print'], '', 'pass');
      return $pdf->stream('document.pdf');
    }

    // paid customer
   
    public function wisePaid(Request $request)
    {
      $data['data'] = Payment::where('customer_id',$request->customer_id)->where('paid_status','!=', 'full_due')->get();
      $pdf = PDF::loadView('frontend.pdf.customer-wise-paid-pdf', $data);
      $pdf->SetProtection(['copy','print'], '', 'pass');
      return $pdf->stream('document.pdf'); 
    }






    public function edit_invoice($invoice_id)
    {
      $payment = Payment::where('invoice_id',$invoice_id)->first();
      
      return view('frontend.customers.edit_invoice',compact('payment'));
    }


    public function update_invoice(InvoiceUpdateRequest $request,$invoice_id)
    {
      
      if($request->new_paid_amount<$request->paid_amount){
        Toastr::error('Soory! you have paid maximun value');
        return redirect()->back();
      }else{
        $payment = Payment::where('invoice_id', $invoice_id)->first();
        $payment_details = new PaymentDetail();
        $payment->paid_status = $request->paid_status;
        if($request->paid_status=='full_paid'){
          $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->first()['paid_amount']+$request->new_paid_amount;
          $payment->due_amount = '0';
          $payment_details -> current_paid_amount= $request->new_paid_amount;
        }elseif($request->paid_status=='partial_paid'){
          $payment->paid_amount = Payment::where('invoice_id',$invoice_id)->first()['paid_amount']+$request->paid_amount;
          $payment->due_amount = Payment::where('invoice_id',$invoice_id)->first()['due_amount']-$request->paid_amount;
          $payment_details->current_paid_amount = $request->paid_amount;
        }
        $payment->save();
        $payment_details->invoice_id = $invoice_id;
        $payment_details->date = date('Y-m-d',strtotime($request->date));
        $payment_details->save();
         Toastr::success('Facture mise a jour avec succès','success');
        return redirect()->route('customers.credit');
      }
    }


    public function invoiceDetailsPdf($invoice_id)
    {
      $data['payment'] = Payment::where('invoice_id', $invoice_id)->first();
      $pdf = PDF::loadView('frontend.pdf.invoice-details-pdf', $data);
      $pdf->SetProtection(['copy','print'], '', 'pass');
      return $pdf->stream('document.pdf');
    }

}
