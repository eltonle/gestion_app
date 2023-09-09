@extends('frontend.layouts.master')


@section('links')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('css')
<style>

</style>
@endsection
@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Factures</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
          <li class="breadcrumb-item active">Factures</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Liste Factures</h3>
          <a href="{{ route('invoices.create') }}" class="btn btn-info btn-sm float-right" title="Create"><i class="fa fa-plus-circle"></i> Ajouter Facture</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          <table id="example1" class="table table-bordered table-striped ">
            <thead>
              <tr>
                <!-- <th>NI</th> -->

                <th>No_facture</th>
                <th>Nom client</th>
                <th>Date</th>
                <th>Status</th>
                <th>Status livraison</th>
                <th>Montant paye</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($invoices as $key => $invoice)
              <tr>
                <!-- <td>{{ $loop->index+1 }}</td> -->

                <td>facture No#{{ $invoice->invoice_no }}</td>
                <td>
                  {{ $invoice['payment']['customer']['name'] }}_
                  {{ $invoice['payment']['customer']['mobile_no'] }}_
                  {{ $invoice['payment']['customer']['address']  }}
                </td>
                <td>{{ date('d-M-Y',strtotime($invoice->date))}}</td>

                <td>
                  @if ($invoice['payment']['paid_status'] == 'full_paid')
                  <span class="badge rounded-pill bg-success"><i class="far fa-handshake"></i> Facture paye</span>
                  @elseif ($invoice['payment']['paid_status'] == 'full_due')
                  <span class="badge rounded-pill bg-danger"><i class="fas fa-times"></i> Non paye.</span>
                  @elseif ($invoice['payment']['paid_status'] == 'partial_paid')
                  <span class="badge rounded-pill bg-info text-dark"><i class="fas fa-balance-scale-right"></i> Partielement paye</span>
                  @endif
                </td>
                <td>
                  @if ($invoice->livraison === 0 )
                  <span class="badge rounded-pill bg-info">en progression ...</span>
                  @elseif ($invoice->livraison === 1)
                  <span class="badge rounded-pill bg-success"> livre <i class="fas fa-user-check"></i><i class="fas fa-user-check"></i> </span>
                  @endif
                </td>
                <td>{{ number_format($invoice['payment']['paid_amount'], 0, ',', ' ') }} FCFA</td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm btn-flat">Action</button>
                    <button type="button" class="btn btn-success btn-xs btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item alert-link" href="{{ route('invoices.edit', $invoice->id) }}"><i class="fa fa-edit"></i> editer</a>
                      <a class="dropdown-item alert-link" href="{{ route('invoices.print', $invoice->id) }}" target="_bank"><i class="fa fa-print"></i> imprimer</a>

                      <a class="dropdown-item alert-link edit-invoice-link" href="#" data-id="{{ $invoice->id }}" data-toggle="modal" data-target="#modal-default">

                        <i class="fas fa-donate"></i> les paiements

                      </a>

                      <!-- <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Action3</a> -->
                    </div>
                  </div>
                </td>

              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <!-- <th>NI</th> -->

                <th>Invoice No</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Status</th>
                <th> Status livraison</th>
                <th>Montant paye</th>
                <th>Actions</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
  <!-- modal  d'historique -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title">Historiques de paiements </h6>
          <button type="button" id="shot" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="d-flex justify-content-center align-items-center w-100">
          <span id="progress-indicator"></span>
        </div>
        <div class="modal-body">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Montant payé</th>
              </tr>
            </thead>
            <tbody id="payment-table-body">
              <!-- Les paiements seront ajoutés ici via AJAX -->
            </tbody>

          </table>
          <hr>
          <div style="text-align: center;" class="mb-5">
            <h6 style="font-style: italic;">information de paiements</h6>
          </div>
          <div style="text-align: center;">
            <span style="font-style: italic; color:green;font-weight: bold;" id="payment-message"></span>
          </div>

          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Montant Total</th>
                <th>Montant Paye</th>
                <th>Reste a Payer</th>
              </tr>
            </thead>
            <tbody id="payment-report">
              <!-- Les paiements seront ajoutés ici via AJAX -->
            </tbody>
          </table>
          <div id="payDiv">
            <form id="my-form">
              @csrf
              <div class="">
                <input type="hidden" id="invoice-id-input" name="invoice_id" value="">
                <div class="w-100 mb-2">
                  <input type="number" min="100" name="paid_amount" id="paid-amount-input" class="form-control " placeholder="Effectuer un paiement">
                  <span id="comparison-message" class="text-danger text-xs italic"></span>
                </div>
                <button type="submit" id="submit-button" class="btn btn-primary w-100" disabled>Soumettre</button>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer  float-right">
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          <button type="button" id="shot" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</section>


@endsection
@section('scripts')

<!-- jQuery -->
<!-- <script src="/plugins/jquery/jquery.min.js"></script> -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- les paiements modal -->
<script>
  $(document).ready(function() {
    $(".edit-invoice-link").on("click", function(event) {
      event.preventDefault();

      var invoiceId = $(this).data("id");
      // Afficher les points de progression pendant le chargement
      var progressIndicator = $("#progress-indicator");
      progressIndicator.html("Chargement en cours...");

      var tbody = $("#payment-table-body");
      tbody.empty(); // Vider le contenu actuel du tbody
      console.log(invoiceId);
      // Effectuer la requête AJAX pour récupérer les détails de la facture
      setTimeout(function() {
        $.ajax({
          url: "{{ route('modalDetails') }}", // Remplacez par l'URL de votre route AJAX
          type: "GET",
          data: {
            invoice_id: invoiceId
          },
          success: function(data) {

            console.log(data);
            // Mettre à jour la partie tbody du tableau avec les données récupérées via AJAX
            var tbody = $("#payment-table-body");
            var tbodyPay = $("#payment-report");
            tbody.empty(); // Vider le contenu actuel du tbody
            tbodyPay.empty(); // Vider le contenu actuel du tbodyPay
            let index = 1
            // Ajouter les données des paiements au tbody
            data.payments.forEach(function(payment) {
              var formattedAmount = parseFloat(payment.current_paid_amount).toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'XOF'
              });
              var row = '<tr>' +
                '<td>' + index++ + '</td>' +
                '<td>' + payment.date + '</td>' +
                '<td>' + formattedAmount + '</td>' +
                '</tr>';
              tbody.append(row);
            });
            var totalAmount = parseFloat(data.fullDataPay.total_amount).toLocaleString('fr-FR', {
              style: 'currency',
              currency: 'XOF'
            });
            var PayAmount = parseFloat(data.fullDataPay.paid_amount).toLocaleString('fr-FR', {
              style: 'currency',
              currency: 'XOF'
            });
            var dueAmount = parseFloat(data.fullDataPay.due_amount).toLocaleString('fr-FR', {
              style: 'currency',
              currency: 'XOF'
            });
            var pay = '<tr>' +
              '<td>' + totalAmount + '</td>' +
              '<td>' + PayAmount + '</td>' +
              '<td style="color: red;">' + dueAmount + '</td>' +
              '</tr>';

            tbodyPay.append(pay);
            // Retirer les points de progression une fois les données chargées
            progressIndicator.empty();
            $("#invoice-id-input").val(data.invoiceId);

            var dueAmountCompare = parseFloat(data.fullDataPay.due_amount);
            var submitButton = $('#submit-button');

            if (data.fullDataPay.total_amount > data.fullDataPay.paid_amount) {
                // Si nbre1 est supérieur à nbre2, affichez la div
                $("#payDiv").show();
              } else if (data.fullDataPay.total_amount == data.fullDataPay.paid_amount) {
                // Si nbre1 est égal à nbre2, masquez la div
                $("#payDiv").hide();
              }

            $('#paid-amount-input').on('input', function() {
              var paidAmount = parseFloat($(this).val());
              var comparisonMessage = $('#comparison-message');

             
              // Vérifier si le champ est vide ou le montant est supérieur
              if (paidAmount > dueAmountCompare) {
                comparisonMessage.html('Le montant saisi est invalide ou supérieur au montant dû.');
                submitButton.prop('disabled', true);
              } else if (isNaN(paidAmount)) {
                comparisonMessage.html('Veuillez saisir un montant.');
                submitButton.prop('disabled', true);
              } else if (paidAmount != 0 || paidAmount <= dueAmountCompare) {
                comparisonMessage.html('');
                submitButton.prop('disabled', false);
              } else {
                comparisonMessage.html('');
                submitButton.prop('disabled', false);
              }
            });

          }
        });
      }, 1000); // Délai de 2 secondes (2000 ms)
    });
  });
</script>
<script>
  $(document).ready(function () {
    $('#shot').on('click',function(){

       
            var tbodyPay = $("#payment-report");
            tbodyPay.empty(); // Vider le contenu actuel du tbodyPay
    })
  })
</script>

<!-- soumttre payement -->
<script>
  $(document).ready(function() {
    $("#my-form").on("submit", function(e) {
      e.preventDefault();

      var submitButton = $('#submit-button');
      submitButton.html('En cours...');

      var invoiceId = $("#invoice-id-input").val();
      var paidAmount = $("#paid-amount-input").val();

      $.ajax({
        url: "{{ route('update-payment') }}", // Remplacez par l'URL de votre route de mise à jour
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          invoice_id: invoiceId,
          paid_amount: paidAmount
        },
        success: function(data) {
          submitButton.html('Soumettre');
          $("#paid-amount-input").val("");
          // Afficher le message "Paiement effectué" dans le span
          $("#payment-message").text("Paiement effectué ✔️").fadeIn();

          // Après deux secondes, masquer le message
          setTimeout(function() {
            $("#payment-message").fadeOut();
            location.reload();
          }, 2000);

        },
        error: function(error) {
          // En cas d'erreur, remettre le texte original sur le bouton
          submitButton.html('Soumettre');

          // Gérer l'erreur
        }
      });
    });
  });
</script>


@endsection