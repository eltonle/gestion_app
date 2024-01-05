@extends('frontend.layouts.master')
{{-- @section('sous-title')
Units
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
        <h1 class="m-0">Utilisateurs <i class="nav-icon fas fa-users"></i></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Accuiel</a></li>
          <li class="breadcrumb-item active">Utilisateurs</li>
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
          <h3 class="card-title">Liste Utilisateurs</h3>
          @can('create-user')
          <a href="{{ route('users.create') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-plus"></i> Creer Utilisateur</a>
          @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="10%">#ID</th>
                <th width="10%">Nom</th>
                <th width="10%">Email</th>
                <th width="30%">Roles</th>
                <th width="20%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td class="text-center">{{ $loop->index+1 }}</td>
                <td class="text-center"> {{ $user->name }}</td>
                <td class="text-center">{{ $user->email }}</td>
                <td class="">
                  <div class="d-flex">
                    @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $roleName)
                    <h5><span class="badge badge-info mr-1">{{ $roleName }}</span></h5>
                    @endforeach
                    @endif
                  </div>
                </td>
                <td class="d-flex ">
                  @can('edit-user')
                  <a class="btn  btn-xs btn-success text-white mr-1" href="{{ route('users.edit', $user->id) }}" title="editer"><i class="nav-icon far fa-edit"></i></a>
                  @endcan
                  @can('delete-user')
                  <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn  btn-danger btn-flat show-alert-delete-box  btn-xs" data-toggle="tooltip" title='supprimer' @if ($user->id==1) disabled

                      @endif><i class="fa fa-trash"></i></button>
                  </form>
                  @endcan
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                {{-- <th>NI</th>
                      <th>Name</th>
                      <th>Actions</th> --}}
                <th width="10%">#ID</th>
                <th width="10%">Nom</th>
                <th width="10%">Email</th>
                <th width="30%">Roles</th>
                <th width="20%">Action</th>
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
      title: "voulez-vous supprimer cet utilisateur?",
      text: "Si vous le supprimez, il disparaîtra pour toujours.",
      icon: "warning",
      type: "warning",
      buttons: ["Annuler", "Oui!"],
      confirmButtonColor: '#D81B60',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Oui, supprime-le!'
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

{{-- <div class="container mb-2">
     <a href="{{ route('users.create') }}" class="float-right btn btn-info mr-2"><i class="fa fa-plus"></i> Add User</a>
</div> --}}
{{-- <table class="table  tab-head bg-gradient-white">
    <thead class="bg-blue">
        <tr>
            <th width="10%" class="text-center">#ID</th>
            <th width="10%" class="text-center">Name</th>
            <th width="10%" class="text-center">Email</th>
            <th width="30%" class="text-center">Roles</th>
            <th width="20%" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user )
        <tr>
            <th class="text-center">{{ $loop->index+1 }}</th>
<td class="text-center"> {{ $user->name }}</td>
<td class="text-center">{{ $user->email }}</td>
<td class=" d-flex items-center bg-gray-light">
  @if (!empty($user->getRoleNames()))
  @foreach ($user->getRoleNames() as $roleName)
  <h5><span class="badge badge-info mr-1">{{ $roleName }}</span></h5>
  @endforeach
  @endif
</td>
<td>
  <a class="btn btn-success text-white" href="{{ route('users.edit', $user->id) }}">Edit</a>

  <a class="btn btn-danger text-white" href="{{ route('users.destroy', $user->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
    Delete
  </a>

  <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
    @method('DELETE')
    @csrf
  </form>
</td>
</tr>
@endforeach
</tbody>
</table> --}}