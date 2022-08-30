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
                    <h1 class="m-0">Clients</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">Editer Client</li>
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
              <h3 class="card-title">Editer Disponibilité & Livraison</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('customers.disponible.status.update',$customer->id) }}">
                    @method('PUT')
                    @csrf
                   <div class="form-row ">
                     <div class="form-group col-md-6">
                        <label for="name">Nom</label>
                        <input type="text" name="name" value="{{ $customer->name }}" class="form-control">
                        @error('name')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="form-group col-md-6">
                        <label for="">Email</label>
                        <input type="email" name="email" value="{{ $customer->email }}" class="form-control">
                        @error('email')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="form-group col-md-6">
                        <label for="">Address</label>
                        <input type="address" name="address" value="{{ $customer->address }}" class="form-control">
                        @error('address')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="form-group col-md-6">
                        <label for="">Phone_number</label>
                        <input type="number" name="mobile_no" value="{{ $customer->mobile_no }}" class="form-control">
                        @error('mobile_no')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>  
                     <div class="form-group col-md-6">
                        <label for="disponible">Disponibilité</label>
                         <select name="disponible" id="disponible" class="form-control">
                            <option value="0" @if ($customer->disponible == '0')selected @endif>Non disponible</option>
                            <option value="1" @if ($customer->disponible == '1')selected @endif>Disponible</option>
                         </select>
                        @error('disponible')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>  
                     <div class="form-group col-md-6">
                        <label for="status">Status Livraison</label>
                         <select name="status" id="status" class="form-control">
                            <option value="0" @if ($customer->status == '0')selected @endif>Non livré</option>
                            <option value="1" @if ($customer->status == '1')selected @endif>Livrée</option>
                         </select>
                        @error('status')
                        <div class="error red">{{ $message }}</div>
                        @enderror
                     </div>  
                     <div class="form-group col-md-6">
                       <input type="submit" value="Enregistrer les modifications" class="btn btn-primary">
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