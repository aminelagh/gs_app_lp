@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Détail de l'entrée de stock: <b>{{ formatDateTime($transaction->created_at) }}</b><small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li><a href="{{ route('stock') }}"><i class="fa fa-cubes"></i> Stock</a></li>
    <li><a href="{{ route('stockINs') }}"><i class="fa fa-history"></i> Historique</a></li>
    <li class="active">Détails de: <b>{{ formatDateTime($transaction->created_at) }}</b></li>
  </ol>


@endsection

@section('content')

  <div class="row">

    <div class="col-md-12">
      {{-- *********************************** Stocks ************************************* --}}
      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="StockINsTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité</th></tr></thead>
                <tbody>
                  @foreach($transaction_articles as $item)
                    <tr align="center">
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->designation }}</td>
                      <td><a href="{{ route('categorie',[$item->id_categorie]) }}">{{ $item->libelle_categorie }}</a></td>
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



@section('scripts')
  <script>

  $(document).ready(function () {

    var table = $('#StockINsTable').DataTable({
      dom: '<lf<Bt>ip>',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'Tout' ]
      ],
      searching: true,
      paging: true,
      //"autoWidth": true,
      info: true,
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
