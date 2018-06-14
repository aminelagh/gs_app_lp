@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Historique des sorties de stock<small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li><a href="{{ route('stock') }}"><i class="fa fa-cubes"></i> Stock</a></li>
    <li class="active"><i class="fa fa-history"></i> Historique des sorties de stock</li>
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
              <table id="dataTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Nombre d'article</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($stockOUTs as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("stockOUT", $item->id_transaction) }}'" title="Double click pour plus de détails" >
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ formatDateTime($item->created_at) }}</td>
                      <td>{{ $item->nombre_articles }}</td>
                      <td>
                        <a href="{{ route("stockOUT", $item->id_transaction) }}"><i class="fa fa-info"></i></a>
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
      {{-- *********************************** Stocks ************************************* --}}
    </div>

  </div>

@endsection



@section('scripts')
  <script>

  $(document).ready(function () {

    var table = $('#dataTable').DataTable({
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
