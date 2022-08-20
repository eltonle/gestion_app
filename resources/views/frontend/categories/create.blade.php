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
                    <h1 class="m-0">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">Creer Categorie</li>
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
              <h4 >Creer Categorie
                 <a href="{{ route('categories.index') }}" class="btn btn-success float-right btn-md">
                  <i class="fa fa-list"> Liste Categories </i>
                </a>
              </h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}">
                    @csrf
                   <div class="form-row ">
                     <div class="form-group col-md-6">
                        <label for="name">Nom Category</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>  
                     <div class="form-group col-md-6" style="padding-top: 30px;">
                       <input type="submit" value="Creer Categorie" class="btn btn-primary">
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