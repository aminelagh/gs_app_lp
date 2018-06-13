@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Détail de le vente: <b>{{ formatDateTime($transaction->created_at) }}</b><small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
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
        </div>
        <div class="box-footer"></div>
      </div>
      {{-- *********************************** vente details ************************************* --}}
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
