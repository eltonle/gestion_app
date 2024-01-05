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
        <h1 class="m-0">Clients <i class="nav-icon fas fa-people-arrows"></i></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
          <li class="breadcrumb-item active">Creer client</li>
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
            <h4>Creer Client
              <a href="{{ route('customers.index') }}" class="btn btn-success float-right btn-md">
                <i class="fa fa-list"> Liste clients </i>
              </a>
            </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('customers.store') }}">
              @csrf
              <div class="form-row ">
                <div class="form-group col-md-6">
                  <label for="name">Nom</label>
                  <input type="text" name="name" class="form-control">
                  @error('name')
                  <div class="error red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group col-md-6">
                  <label for="">Email</label>
                  <input type="email" name="email" class="form-control">
                  @error('email')
                  <div class="error red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group col-md-6">
                  <label for="">Address</label>
                  <input type="address" name="address" class="form-control">
                  @error('address')
                  <div class="error red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group col-md-6">
                  <label for="">Phone_number</label>
                  <input type="number" name="mobile_no" class="form-control">
                  @error('mobile_no')
                  <div class="error red">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group col-md-6">
                  <input type="submit" value="Creer Client" class="btn btn-primary">
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