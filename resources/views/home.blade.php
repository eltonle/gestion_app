@extends('frontend.layouts.master')


@section('content')

<div class="content-header mb-20">
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
            <option value="aujourdhui" @if ($hidden)selected @endif>Aujourd'hui</option>
            <option value="7">Les 7 derniers jours</option>
            <option value="30">Les 30 derniers jours</option>
            <option value="mois_dernier">Le mois dernier</option>
            <option value="ce_mois">Ce mois-çi</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn-sm  btn btn-primary">Recherche</button>
        </div>
      </div>
    </form>


    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <!-- <div class="inner">
                            <p class="text-white">Nombres d'utilisateurs</p>
                            <h3 class="text-white">{{ $nbr_user }}</h3>
                        </div>
                        <div class="icon">
                          <i class="ion ion-person-add"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                      </div> -->
        </div>

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <!-- <div class="small-box bg-info">
                      <div class="inner">
                        <p>Nombres de Clients</p>
                        <h3>{{ $nbr_customer }}</h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div> -->
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <!-- <div class="small-box bg-success">
                      <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
        
                        <p>Bounce Rate</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                      {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div> -->
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <!-- <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>65</h3>
        
                        <p>Unique Visitors</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div> -->
        </div>
        <!-- ./col -->


      </div>


      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-primary text-white mb-4">
            <div class="card-body">
              Total versements net
              <h5>{{ number_format($sum_versement , 0, ',', ' ') }} FCFA</h5>
            </div>
            <!-- <div class="card-footer ">
              <a href="#" class="small text-white stretched-link">Views Details</a>
              <div class="small text-white float-right mt-1"><i class="fas fa-angle-right"></i></div>
            </div> -->
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-success text-white mb-4">
            <div class="card-body">
              Total somme perçue
              <h5> {{ number_format($sum_paid , 0, ',', ' ') }} FCFA</h5>
            </div>

          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-danger text-white mb-4">
            <div class="card-body">
              Total somme credit
              <h5> {{ number_format($sum_due  , 0, ',', ' ') }} FCFA</h5>
            </div>

          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-info text-white mb-4">
            <div class="card-body">
              Total somme remise
              <h5> {{ number_format($sum_discount  , 0, ',', ' ') }} FCFA</h5>
            </div>

          </div>
        </div>

      </div>

    </div>
   <hr>
    <!-- CHARTJS -->
    <div>
      <div class="text-right" style="margin-right: 110px;">
        <label for="year">Sélectionnez une année :</label>
        <select id="year" >
          <!-- Remplacez les années par les années disponibles dans votre base de données -->
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <!-- Ajoutez d'autres années disponibles ici -->
        </select>
      </div>


      <canvas id="myChart" style="position: relative; height:40vh; width:80vw"></canvas>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart;

  function updateChart(year) {
    // Fonction pour mettre à jour le graphique en fonction de l'année sélectionnée
    fetch(`/home/${year}`)
      .then(response => response.json())
      .then(data => {
        console.log(data);
        // Accédez aux données dans l'objet JSON
        var transactions = data[0]; // Remplacez 'transactions' par le nom correct de la clé dans votre objet JSON
        var details = data[1]; // Remplacez 'transactions' par le nom correct de la clé dans votre objet JSON

        // Organisez les données par mois
        var months = Array.from({
          length: 12
        }, (_, i) => i + 1);
        var payeData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.paid_amount, 0));
        var dueData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.due_amount, 0));
        var netPayeData = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.total_amount, 0));
        var details_paiements = months.map(month => details.filter(item => (new Date(item.date).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.current_paid_amount, 0));

        // Mettez à jour le graphique Chart.js
        if (myChart) {
          myChart.destroy();
        }

        myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            datasets: [
              {
                label: 'Somme Payée',
                data: payeData,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
              },
              {
                label: 'Somme Due',
                data: dueData,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
              },
              {
                label: 'Somme Nette à Payer',
                data: netPayeData,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
              },
              {
                label: 'Somme details Payer',
                data: details_paiements,
                borderColor: 'rgba(132, 75, 99, 0.2)',
                backgroundColor: 'rgba(132, 75, 99, 0.2)',
              },
            ],
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });
      });

    // Écoutez les changements dans la sélection d'année
    var yearSelect = document.getElementById('year');
    yearSelect.addEventListener('change', function() {
      updateChart(this.value);
    });
  }
  // Chargez initialement le graphique pour l'année actuelle
  updateChart(new Date().getFullYear());
</script>
@endsection