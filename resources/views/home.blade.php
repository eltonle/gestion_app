@extends('frontend.layouts.master')

@section('css')
<style>
   
</style>
@endsection
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

<div class="">
    <div class="container-fluid">
        <div class="row">
            <div>
                <div class="text-right" style="margin-right: 110px;">
                    <label for="year">Filtre :</label>
                    <select id="year">
                        <!-- Remplacez les années par les années disponibles dans votre base de données -->
                        <option value="day">aujourd'hui</option>
                        <option value="7">7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                        <option value="lastMonth">Le mois dernier</option>
                        <option value="thisMonth">Le mois en cours</option>
                        <option value="thisYear"> Année en cours</option>
                        <option value="lastYear">Année derniere</option>
                    </select>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            Total versements net
                            <h5 id="totalPayeDiv"></h5>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            Total somme perçue
                            <h5 id="totalNetPayeDiv"></h5>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            Total somme credit
                            <h5 id="totalDueDiv"></h5>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            Total somme remise
                            <h5 id="totalDetailsPaiementsDiv"></h5>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <!-- CHARTJS -->

        <div style="display: flex;">
            <div style="flex: 2; padding: 10px;width: 100%; height: 300px;">
                <canvas id="myChart"></canvas>
            </div>
            <div style="flex: 1; padding: 10px;">
                <div style="height: 300px; width: 100%;">
                    <canvas id="myChartPie"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var ctxPie = document.getElementById('myChartPie').getContext('2d');
    var myChart;
    var myChartPie;

    function updateChart(year) {
        // Fonction pour mettre à jour le graphique en fonction de l'année sélectionnée
        fetch(`/home/${year}`)
            .then(response => response.json())
            .then(data => {
                console.log(year);
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
                var discounts = months.map(month => transactions.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.discount_amount, 0));
                var details_paiements = months.map(month => details.filter(item => (new Date(item.created_at).getMonth() + 1) === month).reduce((acc, cur) => acc + cur.current_paid_amount, 0));

                var totalPaye = payeData.reduce((acc, cur) => acc + cur, 0);
                var totalDue = dueData.reduce((acc, cur) => acc + cur, 0);
                var totalNetPaye = netPayeData.reduce((acc, cur) => acc + cur, 0);
                var totalDiscounts = discounts.reduce((acc, cur) => acc + cur, 0);
                var totalDetails = details_paiements.reduce((acc, cur) => acc + cur, 0);
                console.log(totalPaye);

                // Mettez à jour le graphique Chart.js
                if (myChart) {
                    myChart.destroy();
                }
                if (myChartPie) {
                    myChartPie.destroy();
                }

                // Utilisez jQuery pour mettre à jour le contenu des div
                $("#totalPayeDiv").text(totalNetPaye.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalDueDiv").text(totalDue.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalNetPayeDiv").text(totalDetails.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));
                $("#totalDetailsPaiementsDiv").text(totalDiscounts.toLocaleString('fr-FR', {
                    style: 'currency',
                    currency: 'XAF',
                    minimumFractionDigits: 0,
                }));

                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                                label: 'Montant Net',
                                data: netPayeData,
                                borderColor: 'rgba(32, 3, 252, 1)',
                                backgroundColor: 'rgba(732, 3, 252, 0.2)',
                            },
                            // {
                            //     label: 'Montant payé',
                            //     data: payeData,
                            //     borderColor: 'rgba(255, 99, 132, 1)',
                            //     backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            // },
                            
                            {
                                label: 'details Paye',
                                data: details_paiements,
                                borderColor: 'rgba(3, 252, 28)',
                                backgroundColor: 'rgba(3, 252, 28, 0.2)',
                            },
                            {
                                label: 'Montant due ',
                                data: dueData,
                                borderColor: 'rgb(252, 3, 3,1)',
                                backgroundColor: 'rgb(252, 3, 3,1)',
                            },
                        ],
                    },
                    options: {
                        // maintainAspectRatio: false, // Désactiver l'ajustement automatique de la taille
                        // responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
                myChartPie = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: ['total', 'recu', 'impayé', ],
                        datasets: [{
                            data: [totalNetPaye, totalDetails, totalDue],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: [
                                'rgb(3, 74, 252)',
                                'rgb(65, 252, 3)',
                                'rgb(252, 3, 7)',
                            ],
                            hoverOffset: 4
                        }, ],
                    }
                });
            });

        // Écoutez les changements dans la sélection d'année
        var yearSelect = document.getElementById('year');
        yearSelect.addEventListener('change', function() {
            updateChart(this.value);
        });
    }
    // Chargez initialement le graphique pour l'année actuelle
    updateChart(new Date().getDate());
</script>
@endsection