@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Détail de le vente: <b>{{ formatDateTime($transaction->created_at) }}</b> <small style="color:#DF0101"><i>{{ $transaction->valide==false ? "Annulée" : '' }}</i></small></h1>
  <h2></h2>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li><a href="{{ route('stock') }}"><i class="fa fa-cubes"></i> Stock</a></li>
    <li><a href="{{ route('ventes') }}"><i class="fa fa-history"></i> Historique des ventes</a></li>
    <li class="active"><i class=""></i> Vente du {{ $transaction->created_at }}</li>
    <li class="active"></li>
  </ol>
@endsection

@section('content')

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

          <div class="row">

          </div>

        </div>
        @if($transaction->valide)
          <div class="box-footer" align="right">
            <button onclick="annulerVenteFunction()" class="btn btn-danger">Annuler la vente</button>
            <form method="POST" id="formAnnulerVente" action="{{ route('annulerVente') }}">
              @csrf
              <input type="hidden" name="id_transaction" value="{{ $transaction->id_transaction }}">
            </form>
          </div>
        @endif
        <script>
        function annulerVenteFunction(){
          var go = confirm('Vos êtes sur le point d\'annuler cette vente.\n voulez-vous continuer?');
          if(go){
            document.getElementById("formAnnulerVente").submit();
          }
        }
        </script>
      </div>
      {{-- *********************************** vente details ************************************* --}}
    </div>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-body">
          <dl>
            <dt>Client</dt>
            <dd><a href="{{ route('client',[$client->id_client]) }}">{{ $client->nom }} {{ $client->prenom }}</a></dd>

          </dl>
        </div>
      </div>
    </div>
  </div>

@endsection



@section('scripts')
  <script>

  $(document).ready(function () {

    var table = $('#venteDetailsTable').DataTable({
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
        { targets: 00, type: "num", visible: false, searchable: false, orderable: true},  //article
        { targets: 01, type: "string", visible: true, searchable: true, orderable: true},  //article
        //  { targets: 11, width: "", type: "string", visible: false, searchable: true, orderable: false},  //le
      ],
    });

  });
  </script>
@endsection
