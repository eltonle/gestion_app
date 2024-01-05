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
    <div class="row ">
      <div class="col-sm-6">
        <h1>Clients <i class="nav-icon fas fa-people-arrows"></i></h1>
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
          <h3 class="card-title">Liste Clients</h3>
          <a href="{{ route('customers.create') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-plus"></i> Creer un client</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>NI</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Mobile_No</th>
                <th>Address</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($customers as $customer)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->mobile_no }}</td>
                <td>{{ $customer->address }}</td>
                <td class="d-flex ">
                  <a class="btn btn-xs btn-success text-white mr-1" href="{{ route('customers.edit', $customer->id) }}" title="edit"><i class="nav-icon far fa-edit"></i></a>

                  @can('delete-client')
                  @if($customer->payments->count() < 1 ) <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn  btn-danger btn-flat show-alert-delete-box btn-xs " data-toggle="tooltip" title='Delete'><i class="fa fa-trash"></i></button>
                    </form>
                    @endif
                    @endcan
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>NI</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile_No</th>
                <th>Address</th>
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
  $('.show-alert-delete-box').click(function(event) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
      title: "voulez-vous supprimer ce client?",
      text: "Si vous le supprimez, il disparaîtra pour toujours.",
      icon: "warning",
      type: "warning",
      buttons: ["Annuler", "Oui!"],
      confirmButtonColor: '##FF0000',
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