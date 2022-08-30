<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paiement client pdf</title>
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
                        <td> <u><strong><span style="font-size: 17px;">Rapport de client PDF</span></strong></u></td>
                        <td  width="30%"></td>
                    </tr>
                 </tbody>
               </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table border="1" width="100%">
                    <thead>
                    <tr>
                      <th> No_facture</th>
                      <th>Nom client</th>
                      <th>Date</th>
                      <th>Montant paye</th>
                    </tr>
                    </thead>
                    <tbody>
                         @php
                         $total_paid = '0';
                         @endphp
                        @foreach ($data as $payment)
                        <tr>
                            <td>invoice No#{{ $payment['invoice']['invoice_no']}}</td>
                            <td>
                                {{ $payment['customer']['name'] }}(
                                {{ $payment['customer']['mobile_no'] }}_
                                {{ $payment['customer']['address'] }})
                            </td>
                            <td>{{ date('d-M-Y',strtotime($payment['customer']['date'])) }}</td>
                            <td>{{ $payment->paid_amount }} fcfa</td>
                            @php
                            $total_paid +=  $payment->paid_amount
                            @endphp
                         </tr>  
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Grand Total</strong></td>
                            <td style="color: red;"><strong>{{ $total_paid }}</strong> fcfa</td>
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
                          <p style="text-align: center;">Signature client</p>
                        </td>
                    </tr>
                 </tbody>
              </table>
          </div> 
        </div>


    </div>
</body>

</html>