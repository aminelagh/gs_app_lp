@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Gestion de stock<small></small></h1>
  <ol class="breadcrumb">
    <li class="active"><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $articles->count() }}</h3>
          <p>Articles</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a data-toggle="modal" href="#modalAddArticle" class="small-box-footer">Ajouter article <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{ $stocksNumber }}<!--sup style="font-size: 20px">%</sup--></h3>
          <p>Articles dans le stock</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('stock') }}" class="small-box-footer">Plus de détail <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ $total_ventes_mois != null ? $total_ventes_mois." Dhs" : 0 }}</h3>
          <p>Total somme des ventes du dernier mois</p>
        </div>
        <div class="icon">
          <i class="ion ion-calendar"></i>
        </div>
        <a href="{{ route('ventes') }}" class="small-box-footer">Historique des ventes <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ $total_ventes != null ? $total_ventes." Dhs" : 0 }}</h3>
          <p>Total somme des ventes</p>
        </div>
        <div class="icon">
          <i class="ion ion-cart"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div>


</div>


<div class="row">
  <section class="col-lg-6 connectedSortable">

    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-inbox"></i> Ventes par année</li>
      </ul>
      <div class="tab-content no-padding">
        <div id="amchart1" style="width: 100%; height: 400px;"></div>
      </div>
    </div><!-- /.nav-tabs-custom -->

  </section>

  <section class="col-lg-6 connectedSortable">

    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-inbox"></i> Ventes par mois</li>
      </ul>
      <div class="tab-content no-padding">
        <div id="amchart2" style="width: 100%; height: 400px;"></div>
      </div>
    </div><!-- /.nav-tabs-custom -->

  </section>
</div>

<div class="row">
  <section class="col-lg-6 connectedSortable">

    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right">
        <li class="pull-left header"><i class="fa fa-inbox"></i> Articles par catégorie</li>
      </ul>
      <div class="tab-content no-padding">
        <div id="amchart3" style="width: 100%; height: 400px;"></div>
      </div>
    </div><!-- /.nav-tabs-custom -->

  </section>
</div>


<div class="row">

  <div class="col-md-4">
    {{-- *********************************** Categories ************************************* --}}
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Catégories <span class="badge badge-succuess badge-pill" title="Nombre de catégories"> {{ $categories->count() }}</span></h3>
        <div class="box-tools pull-right">
          <button  data-toggle="modal" href="#modalAddCategorie" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Ajouter catégorie</button>
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class=" col-md-12">
            <table id="categoriesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
              <thead><tr><th>Categorie</th><th>Outils</th></tr></thead>
              <tbody>
                @foreach($categories as $item)
                  <tr align="center">
                    <td>{{ $item->libelle }}</td>
                    <td align="center">
                      <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateCategorie" onclick='updateCategorieFunction({{ $item->id_categorie }},"{{ $item->libelle }}" );' title="Modifier" ></i>
                      <i class="glyphicon glyphicon-trash" onclick="deleteCategorieFunction({{ $item->id_categorie }},'{{ $item->libelle }}');" data-placement="bottom" data-original-title="Supprimer" data-toggle="tooltip" ></i>
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
    {{-- *********************************** Categories ************************************* --}}
  </div>

  <div class="col-md-8">
    {{-- *********************************** Articles ************************************* --}}
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Articles <span class="badge badge-succuess badge-pill" title="Nombre d'articles"> {{ $articles->count() }}</span></h3>
        <div class="box-tools pull-right">
          <button data-toggle="modal" href="#modalAddArticle" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Ajouter article</button>
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class=" col-md-12">
            <table id="articlesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
              <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Catégorie</th><th>Outils</th></tr></thead>
              <tbody>
                @foreach($articles as $item)
                  <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->designation }}</td>
                    <td><a href="{{ route('categorie',[$item->id_categorie]) }}">{{ $item->libelle_categorie }}</a></td>
                    <td align="center">
                      <i class="fa fa-edit" data-toggle="modal" data-target="#modalUpdateArticle"
                      onclick='updateArticleFunction({{ $item->id_article }},{{ $item->id_categorie }},{{ $item->id_unite }},"{{ $item->code }}","{{ $item->designation }}","{{ $item->description }}");' title="Modifier" ></i>
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
    {{-- *********************************** Articles ************************************* --}}
  </div>

</div>

@endsection

@section('modals')

  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}

  <div class="CRUD Categorie">

    <form id="formDeleteCategorie" method="POST" action="{{ route('deleteCategorie') }}">
      @csrf
      <input type="hidden" id="delete_id_categorie" name="id_categorie" />
    </form>

    {{-- *****************************    add Categorie   ********************************************** --}}
    <div class="modal fade" id="modalAddCategorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add categorie --}}
      <form method="POST" action="{{ route('addCategorie') }}">
        @csrf

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création de catégorie</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 col-md-offset-2">
                  {{-- Categorie --}}
                  <div class="form-group has-feedback">
                    <label>Categorie</label>
                    <input type="text" class="form-control" placeholder="Catégorie" name="libelle" value="{{ old('libelle') }}" required>
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

    {{-- *****************************    update Categorie   ********************************************** --}}
    <div class="modal fade" id="modalUpdateCategorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update categorie --}}
      <form method="POST" action="{{ route('updateCategorie') }}">
        @csrf
        <input type="hidden" name="id_categorie" id="update_id_categorie" >

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de la catégorie</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 col-md-offset-2">
                  {{-- Categorie --}}
                  <div class="form-group has-feedback">
                    <label>Categorie</label>
                    <input type="text" class="form-control" placeholder="Catégorie" name="libelle" id="update_libelle_categorie" value="{{ old('libell') }}" required>
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

  <div class="CRUD Article">

    <form id="formDeleteArticle" method="POST" action="{{ route('deleteArticle') }}">
      @csrf
      <input type="hidden" id="delete_id_article" name="id_article" />
    </form>

    {{-- *****************************    add Article   ********************************************** --}}
    <div class="modal fade" id="modalAddArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form add Article --}}
      <form method="POST" action="{{ route('addArticle') }}">
        @csrf

        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Création d'un Article</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-5 col-md-offset-1">
                  {{-- id_categorie --}}
                  <div class="form-group has-feedback">
                    <label>Catégorie</label>
                    <select class="form-control" name="id_categorie" required>
                      @foreach ($categories as $item)
                        <option value="{{ $item->id_categorie }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-5">
                  {{-- id_unite --}}
                  <div class="form-group has-feedback">
                    <label>Unité</label>
                    <select class="form-control" name="id_unite" required>
                      @foreach ($unites as $item)
                        <option value="{{ $item->id_unite }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- code --}}
                  <div class="form-group has-feedback">
                    <label>Code</label>
                    <input type="text" class="form-control" placeholder="Code" name="code" value="{{ old('code') }}" required>
                  </div>
                </div>
                <div class="col-md-7">
                  {{-- designation --}}
                  <div class="form-group has-feedback">
                    <label>Designation</label>
                    <input type="text" class="form-control" placeholder="Designation" name="designation" value="{{ old('designation') }}" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{-- description --}}
                  <div class="form-group has-feedback">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Description" name="description">{{ old('description') }}</textarea>
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

    {{-- *****************************    update Article   ********************************************** --}}
    <div class="modal fade" id="modalUpdateArticle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      {{-- Form update article --}}
      <form method="POST" action="{{ route('updateArticle') }}">
        @csrf
        <input type="hidden" name="id_article" id="update_id_article" >

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Modification de la catégorie</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-5 col-md-offset-1">
                  {{-- id_categorie --}}
                  <div class="form-group has-feedback">
                    <label>Catégorie</label>
                    <select class="form-control" name="id_categorie" id="update_id_categorie_article" required>
                      @foreach ($categories as $item)
                        <option value="{{ $item->id_categorie }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-5">
                  {{-- id_unite --}}
                  <div class="form-group has-feedback">
                    <label>Unité</label>
                    <select class="form-control" name="id_unite" id="update_id_unite_article" required>
                      @foreach ($unites as $item)
                        <option value="{{ $item->id_unite }}">{{ $item->libelle }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  {{-- code --}}
                  <div class="form-group has-feedback">
                    <label>Code</label>
                    <input type="text" class="form-control" placeholder="Code" name="code" id="update_code_article" value="{{ old('code') }}" required>
                  </div>
                </div>
                <div class="col-md-7">
                  {{-- designation --}}
                  <div class="form-group has-feedback">
                    <label>Designation</label>
                    <input type="text" class="form-control" placeholder="Designation" name="designation" id="update_designation_article" value="{{ old('designation') }}" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{-- description --}}
                  <div class="form-group has-feedback">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Description" id="update_description_article" name="description">{{ old('description') }}</textarea>
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
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@  chart 1  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <script>
  var chart;
  var graph;

  var chartData = [
    @foreach ($ventesByYear as $item)
    {
      "year": "{{ $item->year }}",
      "value": {{ $item->total==null ? 0 : $item->total }}
    },
    @endforeach
  ];

  AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "year";
    chart.startDuration = 1;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 0;
    categoryAxis.gridPosition = "start";

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "value";
    graph.balloonText = "[[category]]: <b>[[value]] Dhs</b>";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 0.8;
    chart.addGraph(graph);

    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorAlpha = 0;
    chartCursor.zoomable = false;
    chartCursor.categoryBalloonEnabled = false;
    chart.addChartCursor(chartCursor);

    chart.creditsPosition = "top-right";

    chart.write("amchart1");
  });


  </script>
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@  chart 1  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@  chart 2  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <script>
  var chart;
  var graph;

  var chart2Data = [
    @foreach ($ventesByMonth as $item)
    {
      "month": "{{ $item->month }}/{{ $item->year }}",
      "value": {{ $item->total==null ? 0 : $item->total }}
    },
    @endforeach
  ];

  AmCharts.ready(function () {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chart2Data;
    chart.categoryField = "month";
    chart.startDuration = 2;
    chart.fillColorsField = "#000000";

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 45;
    categoryAxis.gridPosition = "start";

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "value";
    graph.balloonText = "[[category]]: <b>[[value]] Dhs</b>";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 0.8;
    chart.addGraph(graph);

    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorAlpha = 0;
    chartCursor.zoomable = false;
    chartCursor.categoryBalloonEnabled = true;
    chart.addChartCursor(chartCursor);
    chart.creditsPosition = "top-right";

    chart.write("amchart2");
  });


  </script>
  {{--  @@@@@@@@@@@@@@@@@@@@@@@@@@  chart 2  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

  {{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@  chart 2   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}
  <script>
  var chart = AmCharts.makeChart("amchart3", {
    "type": "pie",
    "theme": "light",
    "dataProvider": [
      @foreach ($articlesParCategorie as $item)
      {
        "categorie": "{{ $item->libelle_categorie }}",
        "value": {{ $item->nombre_articles or 0 }}
      },
      @endforeach
    ],
    "valueField": "value",
    "titleField": "categorie",
    "outlineAlpha": 0.4,
    "depth3D": 15,
    "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
    "angle": 30,
    "export": {
      "enabled": true
    }
  } );

</script>
{{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@  chart 2   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  --}}

<script src="{{ asset('user_accueil_script.js') }}" type="text/javascript"></script>
@endsection
