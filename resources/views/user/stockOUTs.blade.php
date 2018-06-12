@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Historique des sorties de stock<small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active"></li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-4 col-md-offset-1">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ 22 }}</h3>
          <p>Total nombre d entrées de stock</p>
        </div>
        <div class="icon"><i class="ion ion-bag"></i></div>
        <a data-toggle="modal" href="#modalAddArticle" class="small-box-footer">Nouvelle entrée de stock <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-md-2">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>
          <p>Bounce Rate</p>
        </div>
        <div class="icon"><i class="ion ion-stats-bars"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>

    </div>

    <div class="col-md-4">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>
          <p>Bounce Rate</p>
        </div>
        <div class="icon"><i class="ion ion-stats-bars"></i></div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div>


  <div class="row">

    <div class="col-md-12">
      {{-- *********************************** Stocks ************************************* --}}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Historique des sorties de stock</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="StockINsTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Date</th><th>Nombre d'article</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($stockOUTs as $item)
                    <tr align="center" ondblclick="window.location.href='{{ route("stockOUT", $item->id_transaction) }}'" title="Double click pour plus de détails" >
                      <td>{{ $item->id_transaction }}</td>
                      <td>{{ formatDateTime($item->created_at) }}</td>
                      <td>{{ $item->nombre_articles }}</td>
                      <td>
                        <i class="fa fa-edit"></i>
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

    var table = $('#StockINsTable').DataTable({
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
