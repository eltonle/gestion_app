<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture de crédit</title>
    <style>
        td{
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                   <tbody>
                    <tr>
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
                        <td> <u><strong><span style="font-size: 17px;">Rapport crédit des clients </span></strong></u></td>
                        <td  width="30%"></td>
                    </tr>
                 </tbody>
               </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table border="1" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                      <th>No_facture</th>
                      <th>Nom client</th>
                      <th>Date</th>
                      <th>Montant credit</th>
                    </tr>
                    </thead>
                    <tbody>
                         @php
                         $total_due = '0';
                         @endphp
                        @foreach ($data as $payment)
                        <tr>
                            <td>facture No#{{ $payment['invoice']['invoice_no']}}</td>
                            <td>
                                {{ $payment['customer']['name'] }}(
                                {{ $payment['customer']['mobile_no'] }}_
                                {{ $payment['customer']['address'] }})
                            </td>
                            <td>{{ date('d-M-Y',strtotime($payment['customer']['date'])) }}</td>
                            <td>{{ $payment->due_amount }} FCFA</td>
                            @php
                            $total_due +=  $payment->due_amount
                            @endphp
                         </tr>  
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Grand Total</strong></td>
                            <td style="color: red;"><strong>{{ $total_due }}</strong> FCFA</td>
                        </tr>
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
                          <p style="text-align: center;">Signature client </p>
                        </td>
                    </tr>
                 </tbody>
              </table>
          </div> 
        </div>


    </div>
</body>

</html>