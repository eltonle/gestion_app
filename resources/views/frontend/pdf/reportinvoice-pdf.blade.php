<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Invoice</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                   <tbody>
                    <tr>
                        <td></td>
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
                        <td width="30%"></td>
                        <td> <u><strong><span style="font-size: 17px;">Report Invoice({{ date('d-M-Y',strtotime($start_date)) }} & {{ date('d-M-Y',strtotime($end_date)) }})</span></strong></u></td>
                        <td></td>
                    </tr>
                 </tbody>
               </table>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <table border="1" width=100%>
                <thead>
                <tr>
                  <th>NI</th>
                  <th>Invoice  No</th>
                  <th>Customer Name</th>
                  <th>Date</th>
                  <th>Description</th>
                  <th>total paid</th>
                  {{-- <th>Actions</th> --}}
                </tr>
                </thead>
                <tbody>
                    @php
                        $total_sum = 0;
                    @endphp
                    @foreach ($invoices as $key => $invoice)
                     <tr> 
                        <td>{{ $loop->index+1 }}</td>
                        <td>invoice No#{{ $invoice->invoice_no }}</td>
                        <td>
                            {{ $invoice['payment']['customer']['name'] }}_
                            {{ $invoice['payment']['customer']['mobile_no'] }}_
                            {{ $invoice['payment']['customer']['address']  }}
                        </td>
                        <td>{{ date('d-M-Y',strtotime($invoice->date))}}</td>
            
                        <td>{{ $invoice->description }}</td>
                        <td>{{ $invoice['payment']['total_amount'] }}</td>
                         @php
                             $total_sum += $invoice['payment']['total_amount'];
                         @endphp
                      </tr>  
                    @endforeach
                    <tr>
                        <td colspan="5" style="text-align: right;font-weight:bold;">Grand total</td>
                        <td>
                          <span style="color:red;">{{ $total_sum }}</span> 
                        </td>
                    </tr>
                </tbody>
            
              </table>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
              <hr style="margin-bottom: 0px;">
              <table border="0" width="100%">
                 <tbody>
                    <tr>
                        <td style="width:40%;">
                          {{-- <p style="text-align: center;margin-left: 20px;">Douala: bp cite</p>  --}}
                        </td>
                        <td style="width:20%;"></td>
                        <td style="width:40%;text-align: center;">
                          <p style="text-align: center;border-bottom: 1px solid #000;"> Signature du Responsable</p>
                        </td>
                    </tr>
                 </tbody>
              </table>
          </div> 
        </div>


    </div>
</body>

</html>