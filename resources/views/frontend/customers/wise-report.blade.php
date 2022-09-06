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
                <h1 class="m-0">Rapport clients</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="breadcrumb-item active">clients</li>
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
                  <h3 class="card-title">Sélectionnez les critères</h3></div>
                
                <div class="card-body">
                 <div class="row">
                    <div class="col-md-12 text-center">
                        <strong>Rapport de crédit client avisé</strong>
                        <input type="radio" name="customer_wise_report" value="customer_wise_credit" class="search_value"> &nbsp;&nbsp;
                        <strong>Rapport payé par le client</strong>
                        <input type="radio" name="customer_wise_report" value="customer_wise_paid"  class="search_value">
                    </div>
                </div> 
                <div class="show_credit" style="display: none;">
                  <form method="GET" action="{{ route('customers.wise.credit.report') }}" target="_blank">
                    <div class="form-row">
                        <div class="col-sm-8">
                            <label for="">Nom du client Crédit</label>
                            <select name="customer_id" value="supplier_value" class="form-control select2">
                               <option value="">nom du client</option>
                               @foreach ($customers as $customer)
                                   <option value="{{ $customer->id }}">{{ $customer->name }}({{ $customer->mobile_no }}-{{ $customer->address }})</option>
                               @endforeach
                            </select>
                          </div>
                       <div class="col-sm-4" style="padding-top: 30px;">
                          <button class="btn btn-primary btn-sm">Search</button>
                       </div>
                    </div>
                  </form>
                </div>

                <div class="show_paid" style="display: none;">
                    <form method="GET" action="{{ route('customers.wise.paid.report') }}" target="_blank">
                      <div class="form-row">
                         <div class="col-sm-8">
                           <label for="">Nom du client Payé</label>
                           <select name="customer_id" value="" class="form-control select2">
                              <option value="">nom du client</option>
                              @foreach ($customers as $customer)
                               <option value="{{ $customer->id }}">{{ $customer->name }}({{ $customer->mobile_no }}-{{ $customer->address }})</option>
                              @endforeach
                           </select>
                         </div>
                         <div class="col-sm-4" style="padding-top: 30px;">
                            <button class="btn btn-primary btn-sm">Search</button>
                         </div>
                      </div>
                    </form>
                  </div>
                </div> 
                
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
 
  {{-- show and hide  --}}
  <script>
    $(document).on('change','.search_value',function(){
          var search_value = $(this).val();
          if (search_value == 'customer_wise_credit') {
            $('.show_credit').show();
          }else{
            $('.show_credit').hide();
          }
          if (search_value == 'customer_wise_paid') {
            $('.show_paid').show();
          }else{
            $('.show_paid').hide();
          }
    })
  </script>
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