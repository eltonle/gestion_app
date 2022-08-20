@extends('frontend.layouts.master')

@section('links')

@endsection

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
                    <h1 class="m-0">Rapport facturation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item active">rapport </li>
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
              <h4 >Sélectionner une date</h4>
            </div>

            <div class="card-body">
              <form method="GET" action="{{ route('invoices.report.pdf') }}" target="_blank"  id="myForm">
                <div class="form-row ">
                    
                    <div class="form-group col-sm-4">
                       <label for="">Date de début</label>
                       <input type="date" name="start_date" id="start_date" class="form-control form-control-sm  @error('start_date') is-invalid @enderror" >
                        @error('start_date')
                            <div class="red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-4">
                       <label for="">Date de fin</label>
                       <input type="date" name="end_date" id="end_date" class="form-control form-control-sm  @error('end_date') is-invalid @enderror" >
                       @error('end_date')
                       <div class="red">{{ $message }}</div>
                       @enderror
                    </div>

                    
                    <div class="form-group col-md-2" style="padding-top: 30px;">
                      <button class="btn btn-info  btn-sm" >Rechercher</button>
                    </div>  
                  </div>
              </form>
            </div>
           
            <div class="card-body">
          
            </div>
          </div>
         
        </div>
       
      </div>
     
    </div>
  </section>
@endsection

@section('scripts')
 
    <script type="text/javascript">
      
    </script>
  
    @endsection


