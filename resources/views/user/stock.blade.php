@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Gestion de stock<small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active"><a href="{{ route('stock') }}"><i class="fa fa-cubes"></i> Stock</a></li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-4 col-md-offset-1">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3>{{ $stockINsCount }}</h3>
          <p>Total nombre d'entrées de stock</p>
        </div>
        <div class="icon"><i class="ion ion-bag"></i></div>
        <a href="{{ route('stockINs') }}" class="small-box-footer">Historique des entrées de stock <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-md-2">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $ventesCount }}</h3>
          <p>Total nombre de ventes</p>
        </div>
        <div class="icon"><i class="ion ion-ios-cart-outline"></i></div>
        <a href="{{ route('ventes') }}" class="small-box-footer">Historique des ventes <i class="fa fa-arrow-circle-right"></i></a>
      </div>

    </div>

    <div class="col-md-4">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $stockOUTsCount }}</h3>
          <p>Total nombre de sorties de stock</p>
        </div>
        <div class="icon"><i class="ion ion-stats-bars"></i></div>
        <a href="{{ route('stockOUTs') }}" class="small-box-footer">Historique des sorties de stock <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div>
  <style>
  .btn-app{
    background-color: #859DC0;
  }
  .btn-app:hover {
    background-color: #99A2AE;
  }
  </style>

  <div class="row" align="center">

    <button class="btn btn-app" data-toggle="modal" href="#modalAddStockIN" title="Nouvelle entrée de stock"><i class="fa fa-plus"></i></button>

    <button class="btn btn-app" data-toggle="modal" href="#modalAddVente" title="Nouvelle vente"><i class="glyphicon glyphicon-shopping-cart"></i></button>

    <button class="btn btn-app" data-toggle="modal" href="#modalAddStockOUT" title="Nouvelle sortie de stock"><i class="fa fa-minus"></i></button>

  </div>


  <div class="row">

    <div class="col-md-12">
      {{-- *********************************** Stocks ************************************* --}}
      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="stocksTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité</th></tr></thead>
                <tbody>
                  @foreach($stocks as $item)
                    <tr align="center">
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->designation }}</td>
                      <td><a href="{{ route('categorie',[$item->id_categorie]) }}" target="_blank">{{ $item->libelle_categorie }}</a></td>
                      <td>{{ $item->quantite }} {{ $item->libelle_unite }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="box-footer"></div>
      </div>
      {{-- *********************************** Stocks ************************************* --}}
    </div>

  </div>

@endsection

@section('modals')

  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}
  <div class="CRUD Stock">

    {{-- *****************************    add Stock IN   ********************************************** --}}
    <div class="modal fade" id="modalAddStockIN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Article --}}
      <form name="formAddSockIN" id="formAddSockIN" method="POST" action="{{ route('addStockIN') }}">
        @csrf

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Nouvelle entrée de stock</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">

                  <table id="addStockINTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité actuelle</th><th>Quantité à ajouter</th></tr></thead>
                    <tbody>
                      @foreach($articles as $item)
                        <tr align="center">
                          <input type="hidden" name="id_article[{{ $item->id_article }}]" value="{{ $item->id_article }}">

                          <td>{{ $item->id_article }}</td>
                          <td>{{ $item->code }}</td>
                          <td>{{ $item->designation }}</td>
                          <td><a href="{{ route('categorie',[$item->id_categorie]) }}" target="_blank">{{ $item->libelle_categorie }}</a></td>
                          <td>{{ $item->quantite!=null ? $item->quantite : "0" }} {{ $item->libelle_unite }}</td>
                          <td align="center">
                            <input class="form-control input-sm" maxlength="4" size="2" type="number" min="0" pattern="#.##"
                            name="quantite[{{ $item->id_article }}]">
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <!--button type="submit" class="btn btn-primary">Ajouter</button-->
              <input type="submit" class="btn btn-success" value="Valider" name="submitValidate" form="formAddSockIN">
            </div>
          </div>
        </div>
      </form>
    </div>


    {{-- *****************************    add Stock OUT   ********************************************** --}}
    <div class="modal fade" id="modalAddStockOUT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Stock OUT --}}
      <form name="formAddSockOUT" id="formAddSockOUT" method="POST" action="{{ route('addStockOUT') }}">
        @csrf

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Nouvelle sortie de stock</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">

                  <table id="addStockOUTTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité actuelle</th><th>Quantité à retirer</th></tr></thead>
                    <tbody>
                      @foreach($stocksForOut as $item)
                        <tr align="center">
                          <input type="hidden" name="id_article[{{ $item->id_article }}]" value="{{ $item->id_article }}">

                          <td>{{ $item->id_article }}</td>
                          <td>{{ $item->code }}</td>
                          <td>{{ $item->designation }}</td>
                          <td><a href="{{ route('categorie',[$item->id_categorie]) }}" target="_blank">{{ $item->libelle_categorie }}</a></td>
                          <td>{{ $item->quantite!=null ? $item->quantite : "0" }} {{ $item->libelle_unite }}</td>
                          <td align="center">
                            <input class="form-control input-sm" maxlength="4" size="2" type="number" min="0" max="{{ $item->quantite }}" pattern="#.##"
                            name="quantite[{{ $item->id_article }}]">
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <!--button type="submit" class="btn btn-primary">Ajouter</button-->
              <input type="submit" class="btn btn-success" value="Valider" name="submitValidate" form="formAddSockOUT">
            </div>
          </div>
        </div>
      </form>
    </div>

    <script>
    function calculateTotal(index, last){
      let total = 0;
      let q = 0;
      let p = 0;

      if(document.getElementById('quantite_'+index) == null) q = 0;
      else q = document.getElementById('quantite_'+index).value;

      if(document.getElementById('prix_'+index) == null) p = 0;
      else p = document.getElementById('prix_'+index).value;

      document.getElementById('totalLigne_'+index).value = p*q;

      for(let i=1;i<=last;i++){
        if(document.getElementById('totalLigne_'+i) == null) totalLigne = 0;
        else totalLigne = document.getElementById('totalLigne_'+i).value * 1;
        total += totalLigne;
      }
      document.getElementById('total').value = total;
    }
    </script>

    {{-- *****************************    add Vente   ********************************************** --}}
    <div class="modal fade" id="modalAddVente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Vente --}}
      <form name="formAddVente" id="formAddVente" method="POST" action="{{ route('addVente') }}" target="_blank">
        @csrf

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Nouvelle vente</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">

                  <table id="addVenteTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité actuelle</th>
                        <th>
                          <div class="col-sm-4">Quantité</div>
                          <div class="col-sm-4">Prix unitaire</div>
                          <div class="col-sm-4">PU x Quantité</div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($stocksForOut as $item)
                        <tr align="center">
                          <input type="hidden" name="id_article[{{ $loop->iteration }}]" value="{{ $item->id_article }}">

                          <td>{{ $item->id_article }}</td><td>{{ $item->code }}</td><td>{{ $item->designation }}</td><td>{{ $item->libelle_categorie }}</td>
                          <td>{{ $item->quantite!=null ? $item->quantite : "0" }} {{ $item->libelle_unite }}</td>
                          <td>

                            <div class="row">
                              <div class="">
                                <div class="col-sm-4">
                                  <input class="form-control input-sm" maxlength="4" size="2" type="number" min="0" pattern="#.##" step="0.01"
                                  id="quantite_{{ $loop->iteration }}" max="{{ $item->quantite }}" name="quantite[{{ $loop->iteration }}]"
                                  onkeyup="calculateTotal({{ $loop->iteration }}, {{ $stocks->count() }});"
                                  onkeydown="calculateTotal({{ $loop->iteration }}, {{ $stocks->count() }});"
                                  onclick="calculateTotal({{ $loop->iteration }}, {{ $stocks->count() }});">
                                </div>
                                <div class="col-sm-4">
                                  <input class="form-control input-sm" maxlength="4" size="2" type="number" min="0" pattern="#.##" step="0.01"
                                  id="prix_{{ $loop->iteration }}" name="prix[{{ $loop->iteration }}]"
                                  onkeyup="calculateTotal({{ $loop->iteration }}, {{ $stocks->count() }});"
                                  onkeydown="calculateTotal({{ $loop->iteration }}, {{ $stocks->count() }});"
                                  onclick="calculateTotal({{ $loop->iteration }}, {{ $stocks->count() }});">
                                </div>
                                <div class="col-sm-4">
                                  <input class="form-control input-sm" maxlength="4" size="2" type="number" min="0" pattern="#.##" step="0.01"
                                  id="totalLigne_{{ $loop->iteration }}" readonly>
                                </div>
                              </div>
                            </div>

                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>

              <div class="row">

                <div class="col-md-3 col-md-offset-2">
                  {{-- Total --}}
                  <div class="form-group has-feedback">
                    <label>Total</label>
                    <input type="text" class="form-control" id="total" readonly>
                  </div>
                </div>
                <div class="col-md-7">
                  {{-- id_client --}}
                  <div class="form-group has-feedback">
                    <label>Client</label>
                    <select class="form-control" name="id_client" required>
                      @foreach ($clients as $item)
                        <option value="{{ $item->id_client }}">{{ $item->nom }} {{ $item->prenom }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-success" value="Valider" name="submitValidate" form="formAddVente">
            </div>
          </div>
        </div>
      </form>
    </div>

  </div>
  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}

@endsection

@section('scripts')
  <script>

  $(document).ready(function () {

    //stock table  **********************************************************************
    $('#stocksTable').DataTable({
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
        { targets: 01, type: "string", visible: true, searchable: true, orderable: true},
        //  { targets: 11, width: "", type: "string", visible: false, searchable: true, orderable: false},  //le
      ],
    });
    //************************************************************************************
    //add Stoc IN ************************************************************************
    var tableIN = $('#addStockINTable').DataTable({
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

    $('#formAddSockIN').on('submit', function(e){
      var form = this;
      // Encode a set of form elements from all pages as an array of names and values
      var params = tableIN.$('input,select,text,checkbox, number').serializeArray();
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
    //add stock out ***********************************************************************
    var tableOUT = $('#addStockOUTTable').DataTable({
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
    $('#formAddSockOUT').on('submit', function(e){
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
    //add stock vente *********************************************************************
    var tableVente = $('#addVenteTable').DataTable({
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
        //{ targets: 01, type: "string", visible: true, searchable: true, orderable: true}
      ]
    });

    // Handle form submission event (enable the entire table to be submitted)
    $('#formAddVente').on('submit', function(e){
      var form = this;
      // Encode a set of form elements from all pages as an array of names and values
      var params = tableVente.$('input,select,text,checkbox, number').serializeArray();
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
    //***************************************************************************************

  });

  </script>
@endsection
