@extends('frontend.layouts.master')
{{-- @section('sous-title')
customers
@endsection --}}

@section('links')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
 <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
 <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
 
@endsection

@section('css')
    <style>
      .red{
         color: red;
         font-size: 12px;
      }
    </style>
@endsection
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Credit Client </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="breadcrumb-item active">client</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title mt-1">Modifier la facture</h3>
                  <a href="{{ route('customers.credit') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-list"></i> Liste Credit Client</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td colspan="4" style="font-size: 20px;"><strong>Client infos:</strong></td>
                            </tr>
                            <tr>
                                <td width="30%"><strong>Nom :</strong>{{ $payment['customer']['name'] }}</td>
                                <td width="30%"><strong>Mobile :</strong>{{ $payment['customer']['mobile_no'] }}</td>
                                <td width="40%"><strong>Address :</strong>{{ $payment['customer']['address'] }}</td>
                            </tr>
                        </tbody>
                    </table> 

                    <form method="POST" action="{{ route('customers.update.invoice',$payment->invoice_id) }}">
                        {{-- @method('PUT') --}}
                        @csrf
                        <table class="table-bordered" border="1" width="100%" style="margin-bottom: 10px;">
                            <thead >
                                <tr class="text-center">
                                    <th>NI</th>
                                    <th>Nom Article</th>
                                    <th>Quantite</th>
                                    <th>Prix unitaire</th>
                                    <th>Total Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sum_total = '0';
                                $invoice_details = App\Models\InvoiceDetail::where('invoice_id',$payment->invoice_id)->get();
                                @endphp
                                @foreach ($invoice_details as $key => $details )
                                <tr class="text-center">
                                    <td>{{ $key+1 }}</td>
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
                                    <td colspan="4" class="text-right">Remise</td>
                                    <td class="text-center"><strong>{{ $payment->discount_amount }}</strong></td>
                                </tr>
                                <tr>
                                    {{-- Paid Amount --}}
                                    <td colspan="4" class="text-right">Montant payé</td>
                                    <td class="text-center"><strong>{{ $payment->paid_amount }}</strong></td>
                                </tr>
                                <tr>
                                    {{-- Due Amount --}}
                                    <td colspan="4" class="text-right">Montant dû</td>
                                    <input type="hidden" name="new_paid_amount" value="{{ $payment->due_amount }}">
                                    <td class="text-center"><strong style="color: red;">{{ $payment->due_amount }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                    <td class="text-center"><strong>{{ $payment->total_amount }}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="form-group col-md-3">
                                {{-- Paid Status  --}}
                                <label for="">Statut paiementt</label>
                                <select name="paid_status" id="paid_status" class="form-control form-control-sm  @error('paid_status') is-invalid @enderror">
                                    <option value="">Select status</option>
                                    <option value="full_paid">Full Paid</option>
                                    <option value="partial_paid">Partical Paid</option>
                                </select>
                                <input type="text" name="paid_amount" class="form-control form-control-sm paid_amount" placeholder="Enter Paid Amount" style="display:none;">
                                @error('paid_status')
                                <div class="red">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Date</label>
                                <input type="date"  name="date" id="date" class="form-control form-control-sm  @error('date') is-invalid @enderror">
                                @error('date')
                                <div class="red">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3" style="padding-top: 32px;">
                                {{-- update invoice --}}
                            <button type="submit" class="btn btn-primary btn-sm">Mettre à jour la facture</button>
                            </div>
                        </div>
                  </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
 </section>           


  @endsection

@section('scripts')
  <!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
   $('.show-alert-delete-box').click(function(event){
        var form =  $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "Are you sure you want to delete this customer?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '##FF0000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>

<script type="text/javascript">
     $(document).on('change','#paid_status',function(){
          var paid_status = $(this).val();
          if (paid_status == 'partial_paid') {
            $('.paid_amount').show();
          } else {
            $('.paid_amount').hide();
          }
       })   
</script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>

@endsection