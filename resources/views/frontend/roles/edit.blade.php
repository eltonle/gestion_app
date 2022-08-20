@extends('frontend.layouts.master')

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
                    <h1 class="m-0">Editer Role & Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Editer Role & Permissions</li>
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
              <h4 >Editer Role & Permissions
                 <a href="{{ route('units.index') }}" class="btn btn-success float-right btn-md">
                  <i class="fa fa-list"> Liste Role & Permissions </i>
                </a>
              </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update',$role->id) }}">
                    @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                            </div>
    
                            <div class="form-group">
                                <label for="name">Permissions</label>
    
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkPermissionAll">All</label>
                                </div>
                                <hr>
                                @php $i = 1; @endphp
                                @foreach ($permission_groups as $group)
                                    <div class="row">
                                        @php
                                            $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                            $j = 1;
                                        @endphp
                                        
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                            </div>
                                        </div>
    
                                        <div class="col-9 role-{{ $i }}-management-checkbox">
                                           
                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                    <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                                @php  $j++; @endphp
                                            @endforeach
                                            <br>
                                        </div>
    
                                    </div>
                                    @php  $i++; @endphp
                                @endforeach
                            </div>
                    
                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 mb-2">Enregistrer les modifications</button>
                </form>
            </div>
           
          </div>
         
        </div>
       
      </div>
     
    </div>
  </section>
@endsection
{{-- @section('content') --}}
{{-- <div class="container ml-2">
    <div class="row">
        <div class="col-md-12  bg-white mb-5">
            <form method="POST" action="{{ route('roles.update',$role->id) }}">
                @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    @php
                                        $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    @endphp
                                    
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                       
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @php  $j++; @endphp
                                        @endforeach
                                        <br>
                                    </div>

                                </div>
                                @php  $i++; @endphp
                            @endforeach
                        </div>
                
                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 mb-2">Update Role</button>
            </form>
        </div>
    </div>
</div>
@endsection --}}

@section('scripts')
   @include('frontend.roles.partiels.scripts')
@endsection