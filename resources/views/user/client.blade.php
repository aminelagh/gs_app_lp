@extends('user.layouts.layout')

@section('contentHeader')
  <h1>{{ $client->nom }} {{ $client->prenom }}<small></small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li><a href="{{ route('clients') }}"><i class="fa fa-home"></i> Mes clients</a></li>
    <li class="active"><a href="{{ route('client',[$client->id_client]) }}"><i class="fa fa-user"></i> {{ $client->nom }} {{ $client->prenom }}</a></li>
  </ol>
@endsection

@section('content')
  <script>
  function openVenteDetails(id_transaction) {
    var venteDetails = window.open("../detailsVente/"+id_transaction, "", "resizable=no,status=no,titlebar=no,width=800,height=500");
  }
  </script>

  <div class="row">

    <div class="col-md-6">
      {{-- *********************************** ventes ************************************* --}}
      {{-- Form create facture --}}
      <form name="formAddFacture" id="formAddFacture" method="POST" action="{{ route('addFacture') }}">
        @csrf
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title" title="Ventes du client qui ne sont pas encore dans des factures">nouvelles ventes</h3>
            <div class="box-tools pull-right">
              <button data-toggle="modal" href="#modalAddVente" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Nouvelle vente</button>
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class=" col-md-12">

                <table id="ventesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                  <thead><tr><th> # </th><th>Date</th><th>Nombre d'articles</th><th>Total</th><th>Outils</th></tr></thead>
                  <tbody>
                    @foreach($ventes as $item)
                      <tr align="center" ondblclick="openVenteDetails({{ $item->id_transaction }})" title="Double click pour plus de détails" >

                        <input type="hidden" name="id_transaction[{{ $loop->iteration }}]" value="{{ $item->id_transaction }}">

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ formatDateTime($item->created_at) }}</td>
                        <td>{{ $item->nombre_articles }}</td>
                        <td>{{ $item->total }} Dhs</td>
                        <td align="center">
                          <label>
                            <input type="checkbox" name="checked[{{ $loop->iteration }}]" value="{{ $loop->iteration }}" class="minimal"/>
                          </label>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <div class="box-footer" align="right">
            <input type="submit" class="btn btn-success" value="Valider" name="submitAddFacture" form="formAddFacture">
          </div>
        </div>
      </form>
      {{-- *********************************** ventes ************************************* --}}
    </div>


    <div class="col-md-6">
      {{-- *********************************** Factures OPEN ************************************* --}}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Factures non payées <span class="badge badge-succuess badge-pill" title="Factures non payées"> {{ $facturesOpen->count() }}</span></h3>
          <div class="box-tools pull-right">
            <!--button data-toggle="modal" href="#modalAddFactures" class="btn btn-default" title="effectuer un payement pour la dernière facture ouverte"><i class="glyphicon glyphicon-plus-sign"></i> Nouveau payement</button-->
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table id="facturesOpenTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Nombre de ventes</th><th>Total</th><th>Payé</th><th>Reste</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($facturesOpen as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("facture", $item->id_facture) }}'"  title="Double click pour plus de détails" {{ $item->ferme ? 'class=warning' : '' }}>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ formatDateTime($item->created_at) }}</td>
                      <td>{{ $item->nombre_ventes }}</td>
                      <td>{{ $item->montant }} Dhs</td>
                      <td>{{ $item->paye or 0 }} Dhs</td>
                      <td><font color="#DF0101">{{ $item->reste }} Dhs</font></td>
                      <td align="center">
                        <i class="fa fa-credit-card" data-toggle="modal" data-target="#modalAddPayement" onclick='addPayementFunction({{ $item->id_facture }},"{{ $item->created_at }}" ,{{ $item->montant }},{{ $item->paye or 0 }});' title="ajouter payement" ></i>
                        <i class="fa fa-info" onclick="window.location.href='{{ route('facture',[$item->id_facture]) }}'" title="Plus de details"></i>
                        <!--i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateFacture" onclick='updateFactureFunction({{ $item->id_facture }},"{{ $item->created_at }}" );' title="Modifier" ></i-->
                        <!--i class="glyphicon glyphicon-trash" onclick="deleteFactureFunction({{ $item->id_facture }},'{{ formatDateTime($item->created_at) }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i-->
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="box-footer"></div>
      </div>
      {{-- *********************************** factures OPEN ************************************* --}}
    </div>

  </div>

  <div class="row">

    <div class="col-md-6">
      {{-- *********************************** Factures Closed ************************************* --}}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Factures payées (Fermée) <span class="badge badge-succuess badge-pill" title="Factures payées">{{ $facturesClosed->count() }}</span></h3>
          <div class="box-tools pull-right">
            <!--button data-toggle="modal" href="#modalAddFactures" class="btn btn-default" title="effectuer un payement pour la dernière facture ouverte"><i class="glyphicon glyphicon-plus-sign"></i> Nouveau payement</button-->
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table id="facturesClosedTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Nombre de ventes</th><th>Total</th><th>Payé</th><th>Reste</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($facturesClosed as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("facture", $item->id_facture) }}'" title="Double click pour plus de détails" {{-- $item->ferme ? 'class=warning' : '' --}}>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ formatDateTime($item->created_at) }}</td>
                      <td>{{ $item->nombre_ventes }}</td>
                      <td>{{ $item->montant }} Dhs</td>
                      <td>{{ $item->paye or 0 }} Dhs</td>
                      <td><font color="#DF0101">{{ $item->reste }} Dhs</font></td>
                      <td align="center">
                        <i class="fa fa-info" onclick="window.location.href='{{ route('facture',[$item->id_facture]) }}'" title="Plus de details"></i>
                        <!--i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateFacture" onclick='updateFactureFunction({{ $item->id_facture }},"{{ $item->created_at }}" );' title="Modifier" ></i-->
                        <!--i class="glyphicon glyphicon-trash" onclick="deleteFactureFunction({{ $item->id_facture }},'{{ formatDateTime($item->created_at) }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i-->
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="box-footer"></div>
      </div>
      {{-- *********************************** factures Closed ************************************* --}}
    </div>
  </div>

@endsection

@section('modals')
  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}

  <div class="CRUD Payement">
    <script>
    function addPayementFunction(id_facture, date, montantFacture, montantPaye){

      document.getElementById('id_facture_payement').value = id_facture;
      document.getElementById('date_facture_payement').value = date;
      document.getElementById('montantTotal_facture_payement').value = montantFacture;
      document.getElementById('montantPaye_facture_payement').value = montantPaye;
      document.getElementById('montantReste_facture_payement').value = montantFacture-montantPaye;
      document.getElementById('montant').max = montantFacture-montantPaye;
    }
    </script>

    <form id="formDeletePayement" method="POST" action="{{ route('deletePayement') }}">
      @csrf
      <input type="hidden" id="delete_id_payement" name="id_payement" />
    </form>

    {{-- *****************************    add payement   ********************************************** --}}
    <div class="modal fade" id="modalAddPayement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Payement --}}
      <form method="POST" action="{{ route('addPayement') }}">
        @csrf

        <input type="hidden" name="id_facture" id="id_facture_payement">

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Ajout de payement</h4>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-4 col-md-offset-4">
                  {{-- Date Facture --}}
                  <div class="form-group has-feedback">
                    <label>Date de création de la facture</label>
                    <input type="datetime" class="form-control" id="date_facture_payement" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  {{-- Montant total --}}
                  <div class="form-group has-feedback">
                    <label>Montant total</label>
                    <input type="number" class="form-control" id="montantTotal_facture_payement" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  {{-- Montant Paye --}}
                  <div class="form-group has-feedback">
                    <label>Montant Paye</label>
                    <input type="text" class="form-control" id="montantPaye_facture_payement" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  {{-- Montant reste --}}
                  <div class="form-group has-feedback">
                    <label>Reste</label>
                    <input type="text" class="form-control" id="montantReste_facture_payement" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 col-md-offset-4">
                  {{-- Montant --}}
                  <div class="form-group has-feedback">
                    <label>Montant du payement</label>
                    <input type="number" class="form-control" step="0.01" min="0.00" max="" name="montant" id="montant">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Ajouter</button>
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
  $(document).ready(function(){


    //table ventes du client / create Facture *************************************
    var ventesTable = $('#ventesTable').DataTable({
      dom: '<lf<Bt>ip>',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'Tout' ]
      ],
      searching: true,
      paging: true,
      //"autoWidth": true,
      info: true,
      order: [[0, "asc"]],
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
      var params = ventesTable.$('input,select,text,checkbox, number').serializeArray();
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

    //facturesOpen ***********************************************************************
    var facturesOpenTable = $('#facturesOpenTable').DataTable({
      dom: '<lf<Bt>ip>',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'Tout' ]
      ],
      searching: true,
      paging: true,
      //"autoWidth": true,
      info: true,
      order: [[0, "asc"]],
      stateSave: false,
      columnDefs: [
        { targets: 00, type: "num", visible: false, searchable: false, orderable: true},
        { targets: 01, type: "string", visible: true, searchable: true, orderable: true}
      ]
    });

    // Handle form submission event (enable the entire table to be submitted)
    /*  $('#formAddFacture').on('submit', function(e){
    var form = this;
    // Encode a set of form elements from all pages as an array of names and values
    var params = facturesOpenTable.$('input,select,text,checkbox, number').serializeArray();
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
});*/

//*************************************************************************************

//facturesOpen ***********************************************************************
var facturesClosedTable = $('#facturesClosedTable').DataTable({
  dom: '<lf<Bt>ip>',
  lengthMenu: [
    [ 10, 25, 50, -1 ],
    [ '10', '25', '50', 'Tout' ]
  ],
  searching: true,
  paging: true,
  //"autoWidth": true,
  info: true,
  order: [[0, "asc"]],
  stateSave: false,
  columnDefs: [
    { targets: 00, type: "num", visible: false, searchable: false, orderable: true},
    { targets: 01, type: "string", visible: true, searchable: true, orderable: true},
    { targets: 02, type: "num", visible: true, searchable: true, orderable: true},
  ]
});
//*************************************************************************************

});
</script>
@endsection
