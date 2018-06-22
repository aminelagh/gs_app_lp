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
        <a href="{{ route('articles') }}" class="small-box-footer">Plus de détails <i class="fa fa-arrow-circle-right"></i></a>
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
          <h4 title="Total des ventes du dernier mois">Chiffre d'affaires</h4>
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


  <div class="row">

    <section class="col-lg-12 connectedSortable">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-inbox"></i> Ventes par année</li>
        </ul>
        <div class="tab-content no-padding">
          <div id="amchart2" style="width: 100%; height: 400px;"></div>
        </div>
      </div>
    </section>

  </div>

  <div class="row">

    <section class="col-lg-7 connectedSortable">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-inbox"></i> Ventes par mois</li>
        </ul>
        <div class="tab-content no-padding">
          <div id="amchart1" style="width: 100%; height: 300px;"></div>
        </div>
      </div>
    </section>

    <section class="col-lg-5 connectedSortable">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-inbox"></i> Articles par catégorie</li>
        </ul>
        <div class="tab-content no-padding">
          <div id="amchart3" style="width: 100%; height: 300px;"></div>
        </div>
      </div>
    </section>

  </div>


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
