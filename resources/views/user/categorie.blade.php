@extends('user.layouts.layout')

@section('contentHeader')
  <h1> {{ $categorie->libelle }}<small></small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active"><a href="{{ route('categorie',[$categorie->id_categorie]) }}"><i class="fa fa-home"></i> {{ $categorie->libelle }}</a></li>
  </ol>
@endsection

@section('content')

  <div class="row">

    <div class="col-md-12">
      {{-- *********************************** Articles ************************************* --}}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Articles <span class="badge badge-succuess badge-pill" title="Nombre d'articles"> {{ $articles->count() }}</span></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class=" col-md-12">
              <table id="articlesTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead><tr><th> # </th><th>Code</th><th>Désignation</th><th>Outils</th></tr></thead>
                <tbody>
                  @foreach($articles as $item)
                    <tr align="center">
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->code }}</td>
                      <td>{{ $item->designation }}</td>
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

@section('scripts')
  <script>
  $(document).ready(function(){

    $('#articlesTable').DataTable({
      dom: '<lf<Bt>ip>',
      info: true,
      order: [[ 0,'asc' ]],
      lengthMenu: [
        [ 5, 10, 25, 50, -1 ],
        [ '5', '10', '25', '50', 'Tout' ]
      ],
      columnDefs: [
        { targets: 0, visible: false, orderable: true, searchable: true},
        //{ targets: 0, visible: true, type: "num"},
        //{ targets: 1, visible: true},
      ],
      //order: [[ 0, "asc" ]],
    });

  });
  </script>
  <script src="{{ asset('user_accueil_script.js') }}" type="text/javascript"></script>
@endsection
