@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Historique des ventes<small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active">Historique des ventes</li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-4">
      <div class="info-box">
        <span class="info-box-icon bg-purple"><i class="ion ion-ios-cart-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total somme des ventes du dernier mois</span>
          <span class="info-box-number">{{ $total_ventes_mois != null ? $total_ventes_mois." Dhs" : 0 }}</span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="info-box">
        <span class="info-box-icon bg-blue"><i class="ion ion-ios-cart-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Nombre des ventes</span>
          <span class="info-box-number">{{ $ventes->count() }}</span>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total somme des ventes</span>
          <span class="info-box-number">{{ $total_ventes != null ? $total_ventes." Dhs" : 0 }}</span>
        </div>
      </div>
    </div>

  </div>


  <div class="row">

    <div class="col-md-12">
      {{-- *********************************** Stocks ************************************* --}}
      <div class="box">
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="ventesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Nombre d'article</th><th>Total</th></tr></thead>
                <tbody>
                  @foreach($ventes as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("vente", $item->id_transaction) }}'" title="Double click pour plus de détails" >
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ formatDateTime($item->created_at) }}</td>
                      <td>{{ $item->nombre_articles }}</td>
                      <td>{{ $item->somme_prix or '0' }} Dhs</td>
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

    var table = $('#ventesTable').DataTable({
      dom: '<lf<Bt>ip>',
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10', '25', '50', 'Tout' ]
      ],
      searching: true,
      paging: true,
      //"autoWidth": true,
      order: [[0,'asc' ]],
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
