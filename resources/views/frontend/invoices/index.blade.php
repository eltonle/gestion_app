@extends('frontend.layouts.master')


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
                <h1 class="m-0">Factures</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="breadcrumb-item active">Factures</li>
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
                  <h3 class="card-title">Liste Factures</h3>
                  <a href="{{ route('invoices.create') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-plus-circle"></i> Ajouter Facture</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped ">
                    <thead>
                    <tr>
                      <th>NI</th>
                      <th>No_facture</th>
                      <th>Nom client</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>total payement</th>
                      {{-- <th>Actions</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $key => $invoice)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>facture No#{{ $invoice->invoice_no }}</td>
                            <td>
                                {{ $invoice['payment']['customer']['name'] }}_
                                {{ $invoice['payment']['customer']['mobile_no'] }}_
                                {{ $invoice['payment']['customer']['address']  }}
                            </td>
                            <td>{{ date('d-M-Y',strtotime($invoice->date))}}</td>
                
                            <td>{{ $invoice->description }}</td>
                            <td>{{ $invoice['payment']['paid_amount'] }}</td>
                      
                          </tr>  
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>NI</th>
                        <th>Invoice No</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>total paid</th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                    </tfoot>
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
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection