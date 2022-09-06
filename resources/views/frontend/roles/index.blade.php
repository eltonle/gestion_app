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
                <h1 class="m-0">Roles & Permissions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Roles & Permissions</li>
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
                  <h3 class="card-title">Liste Roles & Permissions</h3>
                  @can('create-role')
                    <a href="{{ route('roles.create') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-plus"></i> Add Roles & Permissions</a>
                  @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="2%" class="text-center">#ID</th>
                        <th width="10%" class="text-center">Role</th>
                        <th width="63%" class="text-center">Permissions</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <th scope="row">{{ $loop->index+1 }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach ($role->permissions as $perm)
                                    <span class="badge badge-info mr-1">
                                        {{ $perm->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="d-flex ">
                                @can('edit-role')
                                  <a class="btn  btn-xs btn-success text-white mr-1" href="{{ route('roles.edit', $role->id) }}" title="editer"><i class="nav-icon far fa-edit"></i></a>
                                @endcan
                                @can('delete-role')
                                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn  btn-danger btn-flat show-alert-delete-box  btn-xs" @if ($role->name=='superadmin')disabled
                                            
                                        @endif data-toggle="tooltip" title='supprimer'><i class="fa fa-trash"></i></button>
                                    </form>
                                @endcan
                           </td>
                          </tr>  
                        @endforeach  
                    </tbody>
                    <tfoot>
                    <tr>
                        <th width="2%" class="text-center">#ID</th>
                        <th width="10%" class="text-center">Role</th>
                        <th width="63%" class="text-center">Permissions</th>
                        <th width="15%" class="text-center">Action</th>
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
                title: "Are you sure you want to delete this uniti?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel","Yes!"],
                confirmButtonColor: '#D81B60',
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
{{-- <table class="table  tab-head bg-gradient-white">
    <thead class="bg-info">
        <tr>
            <th width="2%" class="text-center">#ID</th>
            <th width="10%" class="text-center">Name</th>
            <th width="63%" class="text-center">Permissions</th>
            <th width="15%" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role )
        <tr>
            <th scope="row">{{ $loop->index+1 }}</th>
            <td>{{ $role->name }}</td>
            <td>
                @foreach ($role->permissions as $perm)
                    <span class="badge badge-info mr-1">
                        {{ $perm->name }}
                    </span>
                @endforeach
            </td>
            <td>
                @can('edit-role')
                    <a href="{{ route('roles.edit', $role->id)}}" class="btn btn-success">Edit</a>
                @endcan
                @can('delete-role')
                    <a class="btn btn-danger text-white" href="{{ route('roles.destroy', $role->id) }}"
                      onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                        Delete
                    </a>

                    <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                   
                @endcan
                
            </td>
        </tr>  
        @endforeach
    </tbody>
</table> --}}
