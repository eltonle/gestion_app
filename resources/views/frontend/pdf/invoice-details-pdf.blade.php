<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice details pdf</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                   <tbody>
                    <tr>
                        <td><strong>Invoices No# {{ $payment['invoice']['invoice_no']}}</strong></td>
                        <td>
                            <span style="font-size: 20px;background: #ddd;">Gescom App Mall</span>
                        </td>
                        <td>
                           <span> Showroom No : 001<br/> Service_mobile : <strong>+237 690909090</strong></span>
                        </td>
                    </tr>
                    
                   </tbody>
                </table>
            </div>
        </div>
        <hr style="margin-bottom: 0px;">
        <div class="row">
            <div class="col-md-12">
               <table>
                 <tbody>
                    <tr>
                        <td width="35%"></td>
                        <td> <u><strong><span style="font-size: 17px;">Customer Invoice Details</span></strong></u></td>
                        <td  width="30%"></td>
                    </tr>
                 </tbody>
               </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td colspan="4" style="font-size: 20px;"><strong>Customer info:</strong></td>
                        </tr>
                        <tr>
                            <td width="30%"><strong>Name :</strong>{{ $payment['customer']['name'] }}</td>
                            <td width="30%"><strong>Mobile :</strong>{{ $payment['customer']['mobile_no'] }}</td>
                            <td width="40%"><strong>Address :</strong>{{ $payment['customer']['address'] }}</td>
                        </tr>
                    </tbody>
                </table> 
            </div>
            <div class="col-md-12">
                <table border="1" width="100%" style="margin-bottom: 10px;">
                    <thead >
                        <tr class="text-center">
                            <th>NI</th>
                            {{-- <th>Category</th> --}}
                            <th>Clothes Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $sum_total = '0';
                        $invoice_details = App\Models\InvoiceDetail::where('invoice_id',$payment->invoice_id)->get();
                        @endphp
                        @foreach ($invoice_details as $key => $details )
                        <tr class="text-center">
                            {{-- <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                            <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                            <input type="hidden" name="selling-qty[{{ $details->id }}]"
                                value="{{ $details->selling_qty }}"> --}}
                            <td>{{ $key+1 }}</td>
                            {{-- <td>{{ $details['category']['name'] }}</td> --}}
                            <td>{{ $details['product']['name'] }}</td>
                            <td>{{ $details->selling_qty }}</td>
                            <td>{{ $details->unit_price }}</td>
                            <td>{{ $details->selling_price }}</td>
                        </tr>
                        @php
                        $sum_total = $sum_total + $details->selling_price
                        @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong>{{ $sum_total }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Discount</td>
                            <td class="text-center"><strong>{{ $payment->discount_amount }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Paid Amount</td>
                            <td class="text-center"><strong>{{ $payment->paid_amount }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Due Amount</td>
                            <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}">
                            <td class="text-center"><strong style="color: red;">{{ $payment->due_amount }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                            <td class="text-center"><strong>{{ $payment->total_amount }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: center; font-weight: bold;"><strong>Paid Sommary</strong></td>
                        </tr>
                        <tr> 
                            <td colspan="3" style="text-align: center;"><strong>Date</strong></td>
                            <td colspan="3" style="text-align: center;"><strong>Amount</strong></td>
                        </tr>
                        @php
                            $payment_details = App\Models\PaymentDetail::where('invoice_id', $payment->invoice_id)->get();
                        @endphp
                        @foreach ($payment_details as $details)
                        <tr>
                            <td colspan="3" style="text-align: center;">{{ date('d-M-Y',strtotime($details->date)) }}</td>
                            <td colspan="3" style="text-align: center;">{{ $details->current_paid_amount }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                </table>
                @php
                    $date = new DateTime('now', new DateTimezone('Africa/Douala'));
                @endphp
                <i>Print time : {{ $date->format('F j, Y, H:i:s') }}</i>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <hr style="margin-bottom: 0px;">
              <table border="0" width="100%">
                 <tbody>
                    <tr>
                        <td style="width:40%;">
                          <p style="text-align: center;margin-left: 20px;">Douala: bp cite</p> 
                        </td>
                        <td style="width:20%;"></td>
                        <td style="width:40%;text-align: center;">
                          <p style="text-align: center;">Customer Signature</p>
                        </td>
                    </tr>
                 </tbody>
              </table>
          </div> 
        </div>


    </div>
</body>

</html>