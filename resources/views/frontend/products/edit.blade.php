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
        <h1 class="m-0">Article <i class="nav-icon fas fa-shopping-basket"></i></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
          <li class="breadcrumb-item active">Editer Article</li>
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
            <h4>Editer article
              <a href="{{ route('products.index') }}" class="btn btn-success float-right btn-md">
                <i class="fa fa-list"> Liste articles </i>
              </a>
            </h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('products.update',$product->id) }}">
              @method('PUT')
              @csrf
              <div class="form-row ">
                <div class="form-group col-md-6">
                  <label for="name">Category</label>
                  <select name="category_id" id="" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">select category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ ($product->category_id==$category->id)?"selected":'' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                  @error('category_id')
                  <div class="error red">{{ $message }}</div>
                  @enderror
                </div>


                <div class="form-group col-md-6">
                  <label for="name">Nom</label>
                  <input type="text" name="name" value="{{ $product->name }}" class="form-control @error('name') is-invalid @enderror">
                  @error('name')
                  <div class="error red">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group col-md-6">
                  <input type="submit" value="enregistrer les modifications" class="btn btn-primary">
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