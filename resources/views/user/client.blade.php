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

  <div class="row">

    <div class="col-md-8">
      {{-- *********************************** Factures ************************************* --}}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Factures non payées <span class="badge badge-succuess badge-pill" title="Factures non payées"> {{ $factures->count() }}</span></h3>
          <div class="box-tools pull-right">
            <button data-toggle="modal" href="#modalAddFactures" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Nouvelle facture</button>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table id="facturesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($factures as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("client", $item->id_facture) }}'" title="Double click pour plus de détails" >
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ formatDateTime($item->create_at) }}</td>
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
      {{-- *********************************** factures ************************************* --}}
    </div>

    <div class="col-md-4">
      {{-- *********************************** Payements ************************************* --}}
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
              <table id="facturesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Montant</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($payements as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("client", $item->id_facture) }}'" title="Double click pour plus de détails" >
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ formatDateTime($item->create_at) }}</td>
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

    $('#facturesTable').DataTable({
      dom: '<lf<Bt>ip>',
      info: true,
      order: [[ 0,'asc' ]],
      lengthMenu: [
        [ 5, 10, 25, 50, -1 ],
        [ '5', '10', '25', '50', 'Tout' ]
      ],
      columnDefs: [
        { targets: 0, visible: false, orderable: true, searchable: true},
        //{ targets: 0, visible: true, type: "num"},
        //{ targets: 1, visible: true},
      ],
      //order: [[ 0, "asc" ]],
    });

  });
  </script>
@endsection
