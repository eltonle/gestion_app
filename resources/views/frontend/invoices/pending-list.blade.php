@extends('frontend.layouts.master')
{{-- @section('sous-title')
Customers
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
                <h1 class="m-0">liste de facture en attende</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="breadcrumb-item active">liste de facture en attende</li>
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
                  {{-- <h3 class="card-title">Invoice list</h3> --}}
                  {{-- <a href="{{ route('invoices.create') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-plus-circle"></i> Add invoice</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>NI</th>
                      <th>No_facture</th>
                      <th>Nom Client</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Montant total</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $key => $invoice)
                        <tr >
                            <td>{{ $loop->index+1 }}</td>
                            <td>facture No#{{ $invoice->invoice_no }}</td>
                            <td>
                                {{ $invoice['payment']['customer']['name'] }}_
                                {{ $invoice['payment']['customer']['mobile_no'] }}_
                                {{ $invoice['payment']['customer']['address']  }}
                            </td>
                            <td>{{ date('d-M-Y',strtotime($invoice->date))}}</td>
                
                            <td>{{ $invoice->description }}</td>
                            <td>{{ $invoice['payment']['total_amount'] }}</td>
                             <td>
                                @if ($invoice->status=='0')
                                  <span class="badge bg-danger">en attendant</span>
                                @elseif($invoice->status=='1')
                                  <span>Approuvée</span>
                                @endif
                             </td>
                             <td class="d-flex justify-content-around">
                                @if ($invoice->status=='0')
                                  <a href="{{ route('invoices.approve', $invoice->id) }}" title="Approve" id="approveBtn" class="btn btn-xs btn-success"><i class="fa fa-check-circle"></i></a> 
                                
                                  <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn  btn-danger btn-flat show-alert-delete-box  btn-xs" data-toggle="tooltip" title='Delete'><i class="fa fa-trash"></i></button>
                                </form>
                                  @endif
                             </td>
                          </tr>  
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>NI</th>
                      <th>No_facture</th>
                      <th>Nom Client</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Montant total</th>
                      <th>Status</th>
                      <th>Actions</th>
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
    $('.show-alert-delete-box').click(function(event){
         var form =  $(this).closest("form");
         var name = $(this).data("name");
         event.preventDefault();
         swal({
            title: "voulez-vous annuler cette facture?",
            text: "Si vous le supprimez, il disparaîtra pour toujours.",
            icon: "warning",
            type: "warning",
            buttons: ["Annuler","Oui!"],
            confirmButtonColor: '#D81B60',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, Supprime-le!'
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