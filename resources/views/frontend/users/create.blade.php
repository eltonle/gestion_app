@extends('frontend.layouts.master')

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
                <h1 class="m-0">Utilisateurs <i class="nav-icon fas fa-users"></i></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accuiel</a></li>
                    <li class="breadcrumb-item active">Creer Utilisateur</li>
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
                        <h4>Creer Utilisateur
                            <a href="{{ route('users.index') }}" class="btn btn-success float-right btn-md">
                                <i class="fa fa-list"> Liste utilisateurs </i>
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="name">Nom </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Name">
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="email"> Email </label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Email">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="password">Mot de pass</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password">
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="password_confirmation">Confirmer mot de pass</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="password">Assigner un rôle</label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Creer utilisateur</button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>
@endsection
{{-- @section('content')
    <div class="container ml-2">
        <div class="row">
            <div class="col-12  bg-white mb-5">
                <form method="POST" action="{{ route('users.store') }}">
@csrf
<div class="form-row">
    <div class="form-group col-md-6 col-sm-12">
        <label for="name">User Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Name">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label for="email">User Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Email">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6 col-sm-12">
        <label for="password">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password">
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6 col-sm-12">
        <label for="password">Assign Roles</label>
        <select name="roles[]" id="roles" class="form-control select2" multiple>
            @foreach ($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<button type="submit" class="w-100 btn btn-primary">Create User</button>
</form>
</div>
</div>
</div>
@endsection --}}