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
                <h1 class="m-0">Facture No#{{ $invoice->invoice_no }}({{ date('d-M-Y',strtotime($invoice->date)) }})</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Factures</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Facture</h3>
                    <a href="{{ route('invoices.pendind.list.index') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-list"></i> Listes des factures en attentes</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @php
                    $payment = App\Models\Payment::where('invoice_id',$invoice->id)->first();
                    @endphp
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="15%">
                                    <p><strong style="color:red;">Infos Client </strong></p>
                                </td>
                                <td width="25%">
                                    <p><strong>Name :</strong> {{ $payment['customer']['name'] }}</p>
                                </td>
                                <td width="25%">
                                    <p><strong>Mobile No :</strong>{{ $payment['customer']['mobile_no'] }}</p>
                                </td>
                                <td width="35%">
                                    <p><strong>Address :</strong>{{ $payment['customer']['address'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%"></td>
                                <td width="85%" colspan="3">
                                    <p><strong>Description : </strong>{{ $invoice->description }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <form method="POST" action="{{ route('invoices.approve.store',$invoice->id) }}">
                        @csrf
                        <table border="1" width="100%" class="table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>NI</th>
                                    <th>Categorie</th>
                                    <th>Articles</th>
                                    <th>Quantite</th>
                                    <th>Price Unitaire </th>
                                    <th> Prix Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sum_total = '0';
                                @endphp
                                @foreach ($invoice['invoice_details'] as $key => $details )
                                <tr class="text-center">
                                    <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                                    <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                                    <input type="hidden" name="selling-qty[{{ $details->id }}]" value="{{ $details->selling_qty }}">
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $details['category']['name'] }}</td>
                                    <td>{{ $details['product']['name'] }}</td>
                                    <td>{{ $details->selling_qty }}</td>
                                    <td>{{ $details->unit_price }} FCFA</td>
                                    <td>{{ $details->selling_price }} FCFA</td>
                                </tr>
                                @php
                                $sum_total = $sum_total + $details->selling_price
                                @endphp
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                                    <td class="text-center"><strong>{{ $sum_total }} FCFA</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Remise</td>
                                    <td class="text-center">
                                        <strong>
                                        @if ($payment->discount_amount === NULL)
                                            0
                                            @else
                                            {{ $payment->discount_amount }}
                                            @endif FCFA
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Montant paye</td>
                                    <td class="text-center"><strong>{{ $payment->paid_amount }} FCFA</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Montant Du</td>
                                    <td class="text-center"><strong>{{ $payment->due_amount }} FCFA</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                                    <td class="text-center"><strong>{{ $payment->total_amount }} FCFA</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-info mt-2">Approuver la facture</button>
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
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection