@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Gestion des clients<small></small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active"><a href="{{ route('clients') }}"><i class="fa fa-items"></i> Clients</a></li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-8">
      {{-- *********************************** clients ************************************* --}}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Clients <span class="badge badge-succuess badge-pill" title="Nombre d'articles"> {{ $clients->count() }}</span></h3>
          <div class="box-tools pull-right">
            <button data-toggle="modal" href="#modalAddClient" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Ajouter client</button>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="clientsTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Client</th><th>Télephone</th><th>Email</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($clients as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("client", $item->id_client) }}'" title="Double click pour plus de détails" >
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->nom }} {{ $item->prenom }}</td>
                      <td>{{ $item->tel }}</td>
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
      {{-- *********************************** clients ************************************* --}}
    </div>

  </div>

@endsection

@section('modals')
  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}

  <div class="CRUD Client">

    <form id="formDeleteClient" method="POST" action="{{ route('deleteClient') }}">
      @csrf
      <input type="hidden" id="delete_id_client" name="id_client" />
    </form>

    {{-- *****************************    add Client   ********************************************** --}}
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

    {{-- *****************************    update Client   ********************************************** --}}
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
    $('#clientsTable').DataTable({
      "dom": '<lf<Bt>ip>',
      "info": false,
      "lengthMenu": [
        [ 5, 10, 25, 50, -1 ],
        [ '5', '10', '25', '50', 'Tout' ]
      ],
      "columnDefs": [
        //{ targets:-1, visible: true, orderable: true, searchable: true},
        //{ targets: 0, visible: true, type: "num"},
        //{ targets: 1, visible: true},
      ],
      //order: [[ 0, "asc" ]],
    });

  });

  //Client @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  function updateClientFunction(id_client, nom, prenom, email, tel,description){
    document.getElementById('update_id_client').value = id_client;
    document.getElementById('update_nom_client').value = nom;
    document.getElementById('update_prenom_client').value = prenom;
    document.getElementById('update_email_client').value = email;
    document.getElementById('update_tel_client').value = tel;
    document.getElementById('update_description_client').value = description;
  }

  function deleteClientFunction(id_client, nom, prenom){
    var go = confirm('Vos êtes sur le point d\'effacer l\'élement: "' + nom + ' - ' + prenom + '".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_client").value = id_client;
      document.getElementById("formDeleteClient").submit();
    }
  }

</script>
@endsection
