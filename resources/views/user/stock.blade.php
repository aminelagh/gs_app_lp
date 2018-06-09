@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Gestion de stock<small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active"></li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-4 col-md-offset-1">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $stockINs->count() }}</h3>
          <p>Total nombre d'entrées de stock</p>
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
          <h3 class="box-title">Stock</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <div class="btn-group">
              <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a data-toggle="modal" data-original-title="Profile" data-placement="bottom" href="#modalAddArticle">Ajouter article</a></li>
              </ul>
            </div>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="stocksTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($stocks as $item)
                    <tr align="center">
                      <td>{{ $item->id_stock }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->designation }}</td>
                      <td><a href="{{ route('categorie',[$item->id_categorie]) }}" target="_blank">{{ $item->libelle_categorie }}</a></td>
                      <td>{{ $item->quantite }} {{ $item->libelle_unite }}</td>
                      <td align="center">
                        <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle"
                        onclick='updateFunction("{{ $item->designation }}","{{ $item->description }}");' title="Modifier" ></i>
                        <i class="glyphicon glyphicon-trash" onclick="deleteArticleFunction({{ $item->id_article }},'{{ $item->code }}','{{ $item->designation }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
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

@section('modals')

  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}

  <div class="CRUD Stock">

    <form id="formDeleteStock" method="POST" action="{{ route('deleteArticle') }}">
      @csrf
      <input type="hidden" id="delete_id_article" name="id_article" />
    </form>

    {{-- *****************************    add Stock IN   ********************************************** --}}
    <div class="modal fade" id="modalAddArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Article --}}
      <form name="formAddSockIN" id="formAddSockIN" method="POST" action="{{ route('addStockIN') }}">
        @csrf

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Nouvelle entrée de stock</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">

                  <table id="addStockINTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Quantité</th></tr></thead>
                    <tbody>
                      @foreach($articles as $item)
                        <tr align="center">
                          <input type="hidden" name="id_article[{{ $item->id_article }}]" value="{{ $item->id_article }}">

                          <td>{{ $item->id_article }}</td>
                          <td>{{ $item->code }}</td>
                          <td>{{ $item->designation }}</td>
                          <td><a href="{{ route('categorie',[$item->id_categorie]) }}">{{ $item->libelle_categorie }}</a></td>
                          <td align="center">
                            <input class="form-control" type="number" min="0" pattern="#.##" name="quantite[{{ $item->id_article }}]">
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <!--button type="submit" class="btn btn-primary">Ajouter</button-->
              <input type="submit" class="btn btn-success" value="Valider" name="submitValidate" form="formAddSockIN">
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

  $(document).ready(function () {

    var table = $('#stocksTable').DataTable({
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
      //  ajax: "",
      /*columns: [
      {"className":'details-control',"orderable":false,"defaultContent": ''},
      { "data": "article" },
      { "data": "valide" },
      { "data": "outils" }
    ],*/
  });

  $('#addStockINTable tfoot th').each(function () {
    var title = $(this).text();
    if (title != "") {
      $(this).html('<input type="text" size="8" class="form-control input-sm" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
    }
  });

  var table = $('#addStockINTable').DataTable({
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
    //  ajax: "",
    /*columns: [
    {"className":'details-control',"orderable":false,"defaultContent": ''},
    { "data": "article" },
    { "data": "valide" },
    { "data": "outils" }
  ],*/
});

// Handle form submission event (enable the entire table to be submitted)
$('#formAddSockIN').on('submit', function(e){
  var form = this;
  // Encode a set of form elements from all pages as an array of names and values
  var params = table.$('input,select,text,checkbox, number').serializeArray();
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

$('a.toggle-vis').on('click', function (e) {
  e.preventDefault();
  var column = table.column($(this).attr('data-column'));
  column.visible(!column.visible());
});

});
</script>
<script src="{{ asset('user_stock_script.js') }}" type="text/javascript"></script>
@endsection
