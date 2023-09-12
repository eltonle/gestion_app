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
    
    </style>
@endsection
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Credit Client</h1>
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
                  <h3 class="card-title">Liste Credit clients</h3>
                  <a href="{{ route('customers.credit.pdf') }}" class="btn btn-info btn-sm float-right" title="Create" target="_blank"><i class="fa fa-download"></i> Download PDF</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      {{-- <th>NI</th> --}}
                      <th>No_facture</th>
                      <th>Nom client</th>
                      <th>Date</th>
                      <th>Montant du crédit</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      @php
                      $total_due = '0';
                      @endphp
                        @foreach ($data as $payment)
                        <tr>
                            {{-- <td>{{ $loop->index+1 }}</td> --}}
                            <td>Facture No#{{ $payment['invoice']['invoice_no']}}</td>
                            <td>
                                {{ $payment['customer']['name'] }}(
                                {{ $payment['customer']['mobile_no'] }}_
                                {{ $payment['customer']['address'] }})
                            </td>
                            <td>{{ date('d-M-Y',strtotime($payment['customer']['date'])) }}</td>
                            <td>{{ $payment->due_amount }} fcfa</td>
                            <td class="d-flex ">
                              <!-- <a class="btn btn-xs btn-primary text-white mr-1" href="{{ route('customers.edit.invoice', $payment->invoice_id) }}" title="edit"><i class="nav-icon far fa-edit"></i></a> -->
                              <a href="{{ route('invoices.details.pdf',$payment->invoice_id) }}" target="_blank" title="details" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                            </td>
                            @php
                            $total_due +=  $payment->due_amount
                            @endphp
                          </tr>  
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                    <tr>
                      <th>NI</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile_No</th>
                      <th>Address</th>
                      <th>Actions</th>
                    </tr>
                    </tfoot> --}}
                  </table>

                  <table class="table table-bordered table-hover">
                  
                    <tbody>
                      <td colspan="5" style="text-align: right;"><strong>Grand Total</strong></td>
                      <td style="color: red;"><strong>{{ $total_due }}</strong> fcfa</td>               
                    </tbody>
                  </table>
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

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection