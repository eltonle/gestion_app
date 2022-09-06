@extends('frontend.layouts.master')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Accueil</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
       <div class="container-fluid">
           {{-- <div class="col-md-4"></div> --}}
           <form method="GET" action="{{ route('infos.filter') }}">
            <div class="row mb-2">
              <div class="col-md-7"></div>
              <div class="col-md-3">
                <select name="search_id" id="" class="form-control-sm form-control">
            
                  <option value="aujourdhui" @if ($dayselect=="aujourdhui") selected @endif>Aujourd'hui</option>
                  <option value="7"@if ($dayselect=="7") selected @endif>Les 7 derniers jours</option>
                  <option value="30"@if ($dayselect=="30") selected @endif>Les 30 derniers jours</option>
                  <option value="mois_dernier" @if ($dayselect=="mois_dernier") selected @endif>Le mois dernier</option>
                  <option value="ce_mois" @if ($dayselect=="ce_mois") selected @endif>Ce mois-çi</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn-sm  btn btn-primary">search</button>
              </div>
           </div>
          </form>
           
       
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                          <p class="text-white">Nombres d'utilisateurs</p>
                          <h3 class="text-white">{{ $nbr_user }}</h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                      {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                  </div> 

                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">
                      <p>Nombres de Clients</p>
                      <h3>{{ $nbr_customer }}</h3>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h3>53<sup style="font-size: 20px">%</sup></h3>
      
                      <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                  </div>
                </div>
                <!-- ./col -->
              
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3>65</h3>
      
                      <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                  </div>
                </div>
                <!-- ./col -->

              
              </div>
          

          <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    Total versements net
                    <h5>{{ $sum_versement }} fcfa</h5>
                </div>
                <div class="card-footer ">
                    <a href="#" class="small text-white stretched-link">Views Details</a>
                    <div class="small text-white float-right mt-1"><i class="fas fa-angle-right"></i></div>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    Total somme perçue
                    <h5>{{ $sum_paid }} fcfa</h5>
                </div>
                <div class="card-footer ">
                    <a href="#" class="small text-white stretched-link">Views Details</a>
                    <div class="small text-white float-right mt-1"><i class="fas fa-angle-right"></i></div>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    Total somme credit
                    <h5>{{ $sum_due }} fcfa</h5>
                </div>
                <div class="card-footer ">
                    <a href="#" class="small text-white stretched-link">Views Details</a>
                    <div class="small text-white float-right mt-1"><i class="fas fa-angle-right"></i></div>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    Total somme remise
                    <h5>{{ $sum_discount }} fcfa</h5>
                </div>
                <div class="card-footer ">
                    <a href="#" class="small text-white stretched-link">Views Details</a>
                    <div class="small text-white float-right mt-1"><i class="fas fa-angle-right"></i></div>
                </div>
                </div>
            </div>
           
         </div>
      
       </div>
   </div>
@endsection
