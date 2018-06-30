<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>{{ $title or 'Gestion de stock' }} | Lotis Plast</title>
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
  <!-- Theme style -->
  <link href="{{ asset('dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins         folder instead of downloading all of them to reduce the load. -->
  <link href="{{ asset('dist/css/skins/skin-purple.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- dataTables -->
  <link href="{{ asset('plugins/datatables2/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

  @yield('styles')
</head>

<body class="skin-purple layout-top-nav">

  <div class="wrapper">

    <div class="content-wrapper">
      <div class="container-fluid">

        <section class="content-header">

          <h1>Détail de le vente: <b>{{ formatDateTime($transaction->created_at) }}</b> <small style="color:#DF0101"><i>{{ $transaction->valide==false ? "Annulée" : '' }}</i></small></h1>

        </section>

        <section class="content">

          <div class="row">

            <div class="col-md-12">
              {{-- *********************************** vente details ************************************* --}}
              <div class="box">
                <div class="box-body">

                  <div class="row">
                    <div class=" col-md-12">
                      <table id="venteDetailsTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité</th><th>Prix unitaire</th><th>PU x Quantité</th></tr></thead>
                        <tbody>
                          @php
                          $total = 0;
                          @endphp
                          @foreach($transaction_articles as $item)
                            <tr align="center">
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->code }}</td>
                              <td>{{ $item->designation }}</td>
                              <td>{{ $item->libelle_categorie }}</td>
                              <td>{{ $item->quantite }} {{ $item->libelle_unite }}</td>
                              <td>{{ $item->prix }} Dhs</td>
                              <td>{{ $item->prix * $item->quantite }} Dhs</td>
                            </tr>
                            @php
                            $total += $item->prix * $item->quantite;
                            @endphp
                          @endforeach
                          <tfoot><tr  align="center">
                            <th></th>
                            <th colspan="5">Total</th>
                            <th>{{ $total }} Dhs</th>
                          </tr></tfoot>
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
              {{-- *********************************** vente details ************************************* --}}
            </div>

          </div>

        </section>

      </div>



    </div>



  </div><!-- ./wrapper -->

  <!-- jQuery 2.1.3 -->
  <script src="{{ asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
  <!-- SlimScroll
  <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>-->
  <!-- FastClick
  <script src='plugins/fastclick/fastclick.min.js'></script>-->
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/app.min.js') }}" type="text/javascript"></script>
  <!-- AdminLTE for demo purposes
  <script src="dist/js/demo.js" type="text/javascript"></script> -->

  <!--Toastr -->
  <script src="{{ asset('toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('toastr/toastr.init.js') }}"></script>
  <!-- DATA TABES SCRIPT -->
  <script src="{{ asset('plugins/datatables2/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>

  <script>
  $(document).ready(function(){


    //add stock out ***********************************************************************
    var tableOUT = $('#venteDetailsTable').DataTable({
      dom: '<lf<Bt>ip>',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'Tout' ]
      ],
      searching: true,
      paging: true,
      //"autoWidth": true,
      info: false,
      stateSave: false,
      columnDefs: [
        { targets: 00, type: "num", visible: false, searchable: false, orderable: true},
        { targets: 01, type: "string", visible: true, searchable: true, orderable: true}
      ]
    });

    // Handle form submission event (enable the entire table to be submitted)
    $('#formAddFacture').on('submit', function(e){
      var form = this;
      // Encode a set of form elements from all pages as an array of names and values
      var params = tableOUT.$('input,select,text,checkbox, number').serializeArray();
      // Iterate over all form elements
      $.each(params, function(){
        // If element doesn't exist in DOM
        if(!$.contains(document, form[this.name])){
          // Create a hidden element
          $(form).append(
            $('<input>').attr('type', 'hidden').attr('name', this.name).val(this.value)
          );
        }
      });
    });
    //*************************************************************************************

  });
  </script>


</body>
</html>
