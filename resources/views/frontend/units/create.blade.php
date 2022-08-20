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
                    <h1 class="m-0">Unités</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">accueil</a></li>
                        <li class="breadcrumb-item active">Creer unité</li>
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
              <h4 >Creer Unité
                 <a href="{{ route('units.index') }}" class="btn btn-success float-right btn-md">
                  <i class="fa fa-list"> Liste Unités </i>
                </a>
              </h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('units.store') }}">
                    @csrf
                   <div class="form-row ">
                     <div class="form-group col-md-6">
                        <label for="name">Nom unité</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>  
                     <div class="form-group col-md-6" style="padding-top: 30px;">
                       <input type="submit" value="Creer unite" class="btn btn-primary">
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