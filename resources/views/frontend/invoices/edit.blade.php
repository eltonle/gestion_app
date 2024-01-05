@extends('frontend.layouts.master')

@section('links')

@endsection

@section('css')
<style>
    .red {
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
                <h1 class="m-0">Facture <i class="nav-icon fas fa-balance-scale"></i></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="breadcrumb-item active">Creer Facture</li>
                </ol>
            </div>
        </div>
    </div>
</div>
{{-- main content --}}
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Editer la Facture
                            <a href="{{ route('invoices.index') }}" class="btn btn-success float-right btn-md">
                                <i class="fa fa-list"> Liste factures </i>
                            </a>
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="form-row ">

                            <div class="form-group col-sm-2">
                                <label for="">No_facture</label>
                                <input type="text" name="invoice_no" value="{{ $invoice->invoice_no }}" id="invoice_no" class="form-control form-control-sm" readonly style="background-color:#D8FDBA ">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="">Date</label>
                                <input type="date" value="{{ $invoice->date }}" name="date" id="date" class="form-control form-control-sm" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name">Categorie</label>
                                <select name="category_id" id="category_id" class="form-control select2">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name">Articles</label>
                                <select name="product_id" id="product_id" class="form-control select2">
                                    <option value="">select article</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2" style="padding-top: 30px;">
                                <a class="btn btn-info addeventmore btn-sm"><i class="fa fa-plus-circle "></i> Ajouter un article</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" id="myForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="invoice_no" value="{{ $invoice->invoice_no }}">
                            <!-- <input type="text" name="invoice_no" value="{{ $invoice->invoice_no }}" > -->
                            <!-- <form action="{{ route('invoices.store') }}" method="post" >
                            @csrf -->
                            <table class="table-sm table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Categorie</th>
                                        <th>Nom article</th>
                                        <th width="7%">Pcs/kg</th>
                                        <th width="10%">Unit Price</th>
                                        <!-- <th>description</th> -->
                                        <th width="17%">Total Price</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addRow" class="addRow">
                                    @foreach ($invoice->invoice_details as $invoice_detail)

                                    <tr class="delete_add_more_item" id="delete_add_more_item">
                                        <td>
                                            <input type="hidden" name="category_id[]" value="{{$invoice_detail->category_id}}">

                                            {{ $invoice_detail->category->name }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="product_id[]" value="{{ $invoice_detail->product_id}}">

                                            {{ $invoice_detail->product->name }}
                                        </td>
                                        <td>
                                            <input type="number" min="1" class="form-control form-control-sm text-right selling_qty" name="selling_qty[]" value="{{$invoice_detail->selling_qty}}">
                                        </td>
                                        <td>
                                            <input type="number" min="1" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value="{{$invoice_detail->unit_price}}">
                                        </td>

                                        <td>
                                            <input class="form-control form-control-sm text-right selling_price" name="selling_price[]" value="{{$invoice_detail->selling_price}}" readonly>
                                        </td>
                                        <td>
                                            <i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td class="text-right" colspan="4">Remise</td>
                                        <td><input type="number" name="discount_amount" id="discount_amount" class="form-control form-control-sm discount_amount text-right" value="{{$invoice->payment->discount_amount}}"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4" style="color:#ff0000 ">Grand Total</td>
                                        <td>
                                            <input type="number" name="estimated_amount" value="{{$invoice->payment->total_amount}}" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color:#D8FDBA ">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br />
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <textarea name="description" id="description" class="form-control" placeholder="Une legere description ici...">{{$invoice->description}}</textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for=""> Saisir un payement</label>
                                    <input type="number" name="paid_amount" id="paid_status" class="form-control form-control-sm" value="{{$invoice->payment->paid_amount}}" placeholder="Enter Paid Amount">
                                    <!-- <select name="paid_status" id="paid_status" class="form-control form-control-sm">
                            <option value="">Select status</option>
                            <option value="full_paid">Full Paid</option>
                            <option value="full_due">full Due</option>
                            <option value="partial_paid">Partical Paid</option>
                        </select> -->
                                    <!-- <input type="text" name="paid_amount" class="form-control form-control-sm paid_amount" placeholder="Enter Paid Amount" style="display:none;"> -->
                                </div>


                                <div class="form-group col-md-9">
                                    <label>Nom du client</label>
                                    <select name="customer_id" id="customer_id" class="form-control form-control-sm select2">
                                        <option value="">select customer</option>
                                        @foreach ( $customers as $customer )
                                        <option value="{{ $customer->id }}" {{ ($invoice->payment->customer_id==$customer->id)?"selected":'' }}>{{ $customer->name }} ({{ $customer->mobile_no }})-({{ $customer->address }})</option>
                                        @endforeach
                                        <option value="0">Enregistrer un nouveau Client</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row new_customer" style="display: none;">
                                <div class="form-group col-md-3">
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="entrer nom du client">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="email" name="email" id="name" class="form-control form-control-sm" placeholder="entrer email du client">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-sm" placeholder="entrer le numero du client">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="address" id="address" class="form-control form-control-sm" placeholder="entrer l'address du client">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" id="storeButton" class="btn btn-primary">Enregistrer les modifications</button>
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
<script id="document-template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
       <input type="hidden" name="date" value="@{{date}}">
    
       <input type="hidden" name="invoice_no" value="@{{invoice_no}}">
       <td>
         <input type="hidden" name="category_id[]" value="@{{category_id}}">
          @{{category_name}}
       </td>
       <td>
         <input type="hidden" name="product_id[]" value="@{{product_id}}">
          @{{product_name}}
       </td>
       <td>
         <input type="number" min="1" class="form-control form-control-sm text-right selling_qty" name="selling_qty[]" value="1">
       </td>
       <td>
         <input type="number" min="1" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value="">
       </td>
      
       <td> 
         <input class="form-control form-control-sm text-right selling_price" name="selling_price[]" value="0" readonly>
       </td>
       <td>
         <i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i>
       </td>
     </tr>
  </script>

{{-- extra_add_exist_item --}}
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", ".addeventmore", function() {
            var category_id = $('#category_id').val();
            var category_name = $('#category_id').find('option:selected').text();
            var product_id = $('#product_id').val();
            var product_name = $('#product_id').find('option:selected').text();

            if (date == '') {
                $.notify("Date is required", {
                    globalPosition: 'top right',
                    type: "danger"
                });
                return false;
            }
            if (category_id == '') {
                $.notify("Category is required", {
                    globalPosition: 'top right',
                    type: "danger"
                });
                return false;
            }
            if (product_id == '') {
                $.notify("Product is required", {
                    globalPosition: 'top right',
                    type: "danger"
                });
                return false;
            }

            var source = $("#document-template").html();
            var template = Handlebars.compile(source);
            var data = {
                category_id: category_id,
                category_name: category_name,
                product_id: product_id,
                product_name: product_name,
            };
            var html = template(data);
            $("#addRow").append(html);
        });

        $(document).on("click", ".removeeventmore", function(event) {
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice();
        });

        $(document).on('keyup click', '.unit_price,.selling_qty', function() {
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.selling_qty").val();
            var total = unit_price * qty;
            $(this).closest("tr").find("input.selling_price").val(total);
            //   totalAmountPrice();
            $('#discount_amount').trigger('keyup');
        });
        $(document).on('keyup', '#discount_amount', function() {
            totalAmountPrice();
        });

        //  calcule sum of amount in invoice
        function totalAmountPrice() {
            var sum = 0;
            $(".selling_price").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    sum += parseFloat(value);
                }
            });

            var discount_amount = parseFloat($('#discount_amount').val());
            if (!isNaN(discount_amount) && discount_amount.length != 0) {
                sum -= parseFloat(discount_amount);
            }

            $('#estimated_amount').val(sum);
        }
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#category_id', function() {
            var category_id = $(this).val();
            $.ajax({
                url: "{{route('get-product')}}",
                type: "GET",
                data: {
                    category_id: category_id
                },
                success: function(data) {
                    var html = '<option value="">select Product</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.id + '">' + v.name + '</option>';
                    });
                    $('#product_id').html(html);
                }
            });
        })
    });
</script>

<script>
    // new status
    $(document).on('change', '#paid_status', function() {
        var paid_status = $(this).val();
        if (paid_status == 'partial_paid') {
            $('.paid_amount').show();
        } else {
            $('.paid_amount').hide();
        }
    })
    // new Customer
    $(document).on('change', '#customer_id', function() {
        var customer_id = $(this).val();
        if (customer_id == '0') {
            $('.new_customer').show();
        } else {
            $('.new_customer').hide();
        }
    })
</script>



@endsection