@extends('frontend.layouts.master')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Categories <i class="nav-icon fas fa-blog"></i></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Edit Category</li>
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
            <h4>Editer Categorie
              <a href="{{ route('categories.index') }}" class="btn btn-success float-right btn-md">
                <i class="fa fa-list"> Liste Categories </i>
              </a>
            </h4>
          </div>

          <form class="form-horizontal" method="POST" action="{{ route('categories.update',$category->id) }}">
            @method('PUT')
            @csrf
            <div class="card-body">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nom categorie</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="inputEmail3" value="{{ $category->name }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  <textarea name="description" class="form-control" id="inputPassword3">{{ $category->description }} </textarea>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              {{-- <button type="submit" class="btn btn-info">Sign in</button> --}}
              <button type="submit" class="btn btn-primary float-right">Enregistrer les modifications</button>
            </div>
            <!-- /.card-footer -->
          </form>
        </div>

      </div>

    </div>

  </div>
</section>
@endsection