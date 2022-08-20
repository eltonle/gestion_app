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
                    <h1 class="m-0">Articles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">Creer un article</li>
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
              <h4 >Creer Article
                <a href="{{ route('products.index') }}" class="btn btn-success float-right btn-md">
                 <i class="fa fa-list"> Liste Articles </i>
               </a>
             </h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('products.store') }}">
                    @csrf
                   <div class="form-row ">
                     <div class="form-group col-md-6">
                        <label for="name">Category</label>
                        <select name="category_id" id="" value="{{ old('category_id') }}" class="form-control @error('category_id') is-invalid @enderror">
                          @foreach ($categories as $category)
                           <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                        @error('category_id')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="form-group col-md-6">
                      <label for="name">Unit</label>
                      <select name="unit_id" id="" class="form-control @error('unit_id') is-invalid @enderror">
                        @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                      </select>
                      @error('unit_id')
                      <div class="error red">{{ $message }}</div>
                      @enderror
                   </div>
                   
                     <div class="form-group col-md-12">
                        <label for="name">Nom</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>
                     
                     <div class="form-group col-md-6">
                       <input type="submit" value="Creer Article" class="btn btn-primary">
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