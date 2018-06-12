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

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{ $articles->count() }}</h3>
          <p>Articles</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="#" class="small-box-footer">Plus de details <i class="fa fa-arrow-circle-right"></i></a>
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
          <h3>44</h3>
          <p>Nombre des entrées de stock</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('stockINs') }}" class="small-box-footer">Historique des entrées de stocks<i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>65</h3>
          <p>Articles</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

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
                      <td>{{ $item->id_article }}</td>
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
  <script>
  $(document).ready(function(){
    $('#categoriesTable').DataTable({
      "dom": '<lf<Bt>ip>',
      "info": false,
      "lengthMenu": [
        [ 5, 10, 25, 50, -1 ],
        [ '5', '10', '25', '50', 'Tout' ]
      ],
      "columnDefs": [
        //{ targets:-1, visible: true, orderable: true, searchable: true},
        //{ targets: 0, visible: true, type: "num"},
        //{ targets: 1, visible: true},
      ],
      //order: [[ 0, "asc" ]],
    });

    $('#articlesTable').DataTable({
      dom: '<lf<Bt>ip>',
      info: false,
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
