<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
use TJGazel\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Http\Requests\Report\ReportRequest;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('frontend.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $data['categories'] = Category::all();
        $invoice_data = Invoice::orderBy('id', 'desc')->first();
        if ($invoice_data == null) {
            $firstReg = '0';
            $data['invoice_no'] = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'desc')->first()->invoice_no;
            $data['invoice_no'] = $invoice_data + 1;
        }
        $data['customers'] = Customer::all();
        $data['date'] = date('Y-m-d');
        return view('frontend.invoices.create', $data);
    }


    public function edit($id)
    {

        $data['invoice'] = Invoice::findOrFail($id);
        $data['categories'] = Category::all();
        $data['customers'] = Customer::all();
        $data['date'] = date('Y-m-d'); // You can update this to the appropriate date format

        return view('frontend.invoices.edit', $data); // Make sure to create the 'edit' view
    }

    public function store(Request $request)
    {
        // dd($request)->all();
        if ($request->category_id == null) {

            Toastr::error('Sorry! you do not select any product', 'error');
            return redirect()->back();
        } else {
            if ($request->paid_amount > $request->estimated_amount) {
                Toastr::error('Sorry! paid paid_amount is maximun than total', 'error');
                return redirect()->back();
            } else {
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;
                DB::transaction(function () use ($request, $invoice) {
                    if ($invoice->save()) {
                        $count_category = count($request->category_id);
                        for ($i = 0; $i < $count_category; $i++) {

                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = date('Y-m-d', strtotime($request->date));
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '1';
                            $invoice_details->save();
                        }

                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->email = $request->email;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->address = $request->address;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }
                        $payment = new Payment();
                        $payment_details = new PaymentDetail();
                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        // $payment->paid_status = $request->paid_status;
                        // $payment->paid_amount = $request->paid_amount;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;
                        // if ($request->paid_status=='full_paid') {
                        if ($request->paid_amount == $request->estimated_amount) {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment->paid_status = 'full_paid';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } elseif ($request->paid_amount == '0') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment->paid_status = 'full_due';
                            $payment_details->current_paid_amount = '0';
                        } elseif ($request->paid_amount > 0 && $request->paid_amount < $request->estimated_amount) {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->paid_status = 'partial_paid';
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }
                        $payment->save();
                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->date));
                        $payment_details->save();
                    }
                });
            }
        }
        Toastr::success('Saved successfully', 'success');
        return redirect()->route('invoices.pendind.list.index');
    }

    //    code pour update la facture

    public function update(Request $request, $id)
    {
        //  dd($request->invoice_no);
        if ($request->category_id == null) {

            Toastr::error('Sorry! you do not select any product', 'error');
            return redirect()->back();
        } else {
            if ($request->paid_amount > $request->estimated_amount) {
                Toastr::error('Sorry! paid paid_amount is maximun than total', 'error');
                return redirect()->back();
            } else {
                $invoice = Invoice::find($id);
                // $invoice->invoice_no = $request->invoice_no;
                $invoice->date = Carbon::now();
                $invoice->description = $request->description;
                $invoice->status = '1';
                $invoice->created_by = Auth::user()->id;
                DB::transaction(function () use ($request, $invoice) {
                    if ($invoice->save()) {
                        $invoice->invoice_details()->delete(); // Supprimer les anciens détails de la facture

                        $count_category = count($request->category_id);
                        for ($i = 0; $i < $count_category; $i++) {
                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = now();
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '1';
                            $invoice_details->save();
                        }
                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->email = $request->email;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->address = $request->address;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }
                        // Autres mises à jour et création de nouvelles entrées liées
                        // $payment = new Payment();
                        // $payment_details = new PaymentDetail();
                        // Exemple de mise à jour des paiements (à adapter en fonction de vos besoins)
                        $payment = Payment::where('invoice_id', $invoice->id)->firstOrFail();
                        // $paymentDetail = PaymentDetail::where('invoice_id', $invoice->id)->first();
                        if ($payment) {
                            $payment->invoice_id = $invoice->id;
                            $payment->customer_id = $customer_id;
                            // Mettez à jour les champs nécessaires du paiement
                                                    
                            // $payment_details = new PaymentDetail();
                            $payment_details = PaymentDetail::where('invoice_id', $invoice->id)->firstOrFail();
                            $payment->invoice_id = $invoice->id;
                            $payment->customer_id = $customer_id;
                            // $payment->paid_status = $request->paid_status;
                            // $payment->paid_amount = $request->paid_amount;
                            $payment->discount_amount = $request->discount_amount;
                            $payment->total_amount = $request->estimated_amount;
                            // if ($request->paid_status=='full_paid') {
                            if ($request->paid_amount == $request->estimated_amount) {
                                $payment->paid_amount = $request->estimated_amount;
                                $payment->due_amount = '0';
                                $payment->paid_status = 'full_paid';
                                $payment_details->current_paid_amount = $request->estimated_amount;
                            } elseif ($request->paid_amount == '0') {
                                $payment->paid_amount = '0';
                                $payment->due_amount = $request->estimated_amount;
                                $payment->paid_status = 'full_due';
                                $payment_details->current_paid_amount = '0';
                            } elseif ($request->paid_amount > 0 && $request->paid_amount < $request->estimated_amount) {
                                $payment->paid_amount = $request->paid_amount;
                                $payment->paid_status = 'partial_paid';
                                $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                                $payment_details->current_paid_amount = $request->paid_amount;
                            }
                            $payment->save();
                            $payment_details->invoice_id = $invoice->id;
                            $payment_details->date = now();
                            $payment_details->save();
                            $payment->save();
                        }
                    }
                });
              
            }
        }

        Toastr::success('Mise a jour effectuer avec success', 'success');
        return redirect()->route('invoices.index');
    }




    public function pendingList()
    {
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
        return view('frontend.invoices.pending-list', compact('invoices'));
    }

    public function approvedInvoice($id)
    {
        $invoice = Invoice::with('invoice_details')->find($id);
        return view('frontend.invoices.approve-list', compact('invoice'));
    }

    public function approvedStore(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->approved_by = Auth::user()->id;
        $invoice->status = '1';
       
        $invoice->save();
        Toastr::success('Facture Approvée avec success', 'success');
        return redirect()->route('invoices.index');
    }

    public function printInvoiceList()
    {
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('frontend.invoices.printinvoicelist', compact('invoices'));
    }



    function printInvoice($id)
    {
        $data['invoice'] = Invoice::with('invoice_details')->find($id);
        $pdf = PDF::loadView('frontend.pdf.invoice-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }



    public function report()
    {
        return view('frontend.invoices.report');
    }

    public function reportpdf(ReportRequest $request)
    {
        $sdata = date('Y-m-d', strtotime($request->start_date));
        $edata = date('Y-m-d', strtotime($request->end_date));
        $data['invoices'] = Invoice::whereBetween('date', [$sdata, $edata])->where('status', '1')->get();
        $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
        $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
        $pdf = PDF::loadView('frontend.pdf.reportinvoice-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }


    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();

        Toastr::success('Facture annulée avec success ', 'success');
        return redirect()->route('invoices.pendind.list.index');
    }

    // recuperation des payments
    public function getInvoicePayment(Request $request)
    {
        $invoiceId = $request->input('invoice_id');
        $fullDataPay = Payment::where('invoice_id', $invoiceId)->first();

        $payments = PaymentDetail::where('invoice_id', $invoiceId)->get();
        // $payments = PaymentDetail::all();

        return response()->json([
            'payments' => $payments,
            'invoiceId' => $invoiceId,
            'fullDataPay' => $fullDataPay
        ]);
    }

    // recuperation du status de livraison
    public function getInvoiceDelivrery(Request $request)
    {
        $invoiceId = $request->input('invoice_id');
        $statusDelivrery = Invoice::where('id', $invoiceId)->first();

        return response()->json([
            'statusDelivrery' => $statusDelivrery,
            'invoiceId' => $invoiceId,
        ]);
    }

    // mettre a jour les paiements
    public function updatePayment(Request $request)
    {

        $invoiceId = $request->input('invoice_id');
        $paidAmount = $request->input('paid_amount');
        $invoiceUpdate = Invoice::findOrFail($invoiceId);
        $payment = Payment::where('invoice_id', $invoiceId)->firstOrFail();
        $existPaidAmount = $payment->paid_amount;
        $existDueAmount = $payment->due_amount;
        $payment->paid_amount =  $paidAmount + $existPaidAmount;
        $payment->due_amount = $existDueAmount - $paidAmount;
        if ($existDueAmount == $paidAmount) {
            $payment->paid_status = 'full_paid';
            $invoiceUpdate->livraison = '0';
        }
        DB::transaction(
            function () use ($request, $payment) {
                $invoiceId = $request->input('invoice_id');
                $paidAmount = $request->input('paid_amount');
                if ($payment->save()) {
                    $newPaymentDetails = new PaymentDetail();
                    $newPaymentDetails->invoice_id = $invoiceId;
                    $newPaymentDetails->current_paid_amount = $paidAmount;
                    $newPaymentDetails->date = now();
                    $newPaymentDetails->save();
                }
            }
        );
        if ($payment->paid_status = 'full_paid') {
            # code...
            $invoiceUpdate->save();
        }

        // Effectuez les opérations nécessaires pour mettre à jour les champs dans la base de données

        return response()->json(['message' => 'Paiement effectue avec succès .']);
    }

    public function updateDelivrery(Request $request)
    {
        $invoiceId = $request->input('invoice_id');
        $livraison = $request->input('livraison');
        $paidAmount = Payment::where('invoice_id',$invoiceId)->first()->paid_amount;
        $totalAmount = Payment::where('invoice_id',$invoiceId)->first()->total_amount;

        if ($livraison == "1"&& $paidAmount === $totalAmount) {
            DB::table('invoices')
            ->where('id',$invoiceId)
            ->update([
                'livraison'=> $livraison
            ]);
            return response()->json([
                'message' => 'Status modifie avec succès ✔️ .',
                'error'  => ''
            ]);
        }else {
            return response()->json([
                'error' => '⌛ Echec:Veuillez payer de votre dette ⌛ .',
                'message'=> ''
            ]);
        }
       
       

    }
}
