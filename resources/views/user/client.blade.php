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
            <h3 class="box-title" title="Ventes du client qui ne sont pas encore dans des factures">Ventes</h3>
            <div class="box-tools pull-right">
              <button data-toggle="modal" href="#modalAddFactures" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Nouveau Payement</button>
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

      <div class="row">
        <div class="col-sm-12">
          {{-- *********************************** Factures OPEN ************************************* --}}
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Factures non payées <span class="badge badge-succuess badge-pill" title="Factures non payées"> {{ $facturesOpen->count() }}</span></h3>
              <div class="box-tools pull-right">
                <button data-toggle="modal" href="#modalAddFactures" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Nouvelle facture</button>
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
                        <tr align="center" title="Double click pour plus de détails" >
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ formatDateTime($item->created_at) }}</td>
                          <td>{{ $item->nombre_ventes }}</td>
                          <td>{{ $item->montant }} Dhs</td>
                          <td>{{ $item->paye or 0 }} Dhs</td>
                          <td><font color="#DF0101">{{ $item->montant-$item->paye }} Dhs</font></td>
                          <td align="center">
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
        <div class="col-sm-12">
          {{-- *********************************** Payements ************************************* --}
          <div class="box">
          <div class="box-header with-border">
          <h3 class="box-title">Payements</h3>
          <div class="box-tools pull-right">
          <button data-toggle="modal" href="#modalAddFactures" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Nouveau Payement</button>
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
      <div class="row">
      <div class=" col-md-12">
      <table id="payementsTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
      <thead><tr><th> # </th><th>Date</th><th>Montant</th><th>Outils</th></tr></thead>
      <tbody>
      @foreach($payements as $item)
      <tr align="center" ondblclick="window.location.href='{{ route("client", $item->id_facture) }}'" title="Double click pour plus de détails" >
      <td>{{ $loop->iteration }}</td>
      <td>{{ formatDateTime($item->created_at) }}</td>
      <td><a href="mailto: {{ $item->email }}">{{ $item->email }}</a></td>
      <td align="center">
      <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateClient"
      onclick='updateClientFunction({{ $item->id_client }},"{{ $item->nom }}","{{ $item->prenom }}","{{ $item->email }}","{{ $item->tel }}","{{ $item->description }}");' title="Modifier" ></i>
      <i class="glyphicon glyphicon-trash" onclick="deleteClientFunction({{ $item->id_client }},'{{ $item->nom }}','{{ $item->prenom }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
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
{{-- *********************************** Payements ************************************* --}}
</div>
</div>

</div>


</div>

@endsection

@section('modals')
  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}

  <div class="CRUD Payement">

    <form id="formDeletePayement" method="POST" action="{{ route('deletePayement') }}">
      @csrf
      <input type="hidden" id="delete_id_payement" name="id_payement" />
    </form>

    {{-- *****************************    add peyement   ********************************************** --}}
    <div class="modal fade" id="modalAddClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Client --}}
      <form method="POST" action="{{ route('addClient') }}">
        @csrf

        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'un client</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-5">
                  {{-- Nom --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ old('nom') }}" required>
                  </div>
                </div>
                <div class="col-md-5">
                  {{-- Prenom --}}
                  <div class="form-group has-feedback">
                    <label>Prenom</label>
                    <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="{{ old('pernom') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- Email --}}
                  <div class="form-group has-feedback">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                  </div>
                </div>
                <div class="col-md-5">
                  {{-- Telephone --}}
                  <div class="form-group has-feedback">
                    <label>Telephone</label>
                    <input type="text" class="form-control" placeholder="Telephone" name="tel" value="{{ old('tel') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{-- description --}}
                  <div class="form-group has-feedback">
                    <label>Description</label>
                    <textarea class="form-control" name="description">{{ old('description') }}</textarea>
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

    {{-- *****************************    update payement   ********************************************** --}}
    <div class="modal fade" id="modalUpdateClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update client --}}
      <form method="POST" action="{{ route('updateClient') }}">
        @csrf
        <input type="hidden" name="id_client" id="update_id_client">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification du client</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-5">
                  {{-- Nom --}}
                  <div class="form-group has-feedback">
                    <label>Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" name="nom" value="{{ old('nom') }}" id="update_nom_client" required>
                  </div>
                </div>
                <div class="col-md-5">
                  {{-- Prenom --}}
                  <div class="form-group has-feedback">
                    <label>Prenom</label>
                    <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="{{ old('pernom') }}" id="update_prenom_client">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- Email --}}
                  <div class="form-group has-feedback">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" id="update_email_client">
                  </div>
                </div>
                <div class="col-md-5">
                  {{-- Telephone --}}
                  <div class="form-group has-feedback">
                    <label>Telephone</label>
                    <input type="text" class="form-control" placeholder="Telephone" name="tel" value="{{ old('tel') }}" id="update_tel_client">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{-- description --}}
                  <div class="form-group has-feedback">
                    <label>Description</label>
                    <textarea class="form-control" name="description" id="update_description_client">{{ old('description') }}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Modifier</button>
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

});
</script>
@endsection
