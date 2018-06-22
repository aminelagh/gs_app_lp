@extends('user.layouts.layout')

@section('contentHeader')
  <h1>Gestion des articles<small></small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('accueil') }}"><i class="fa fa-home"></i> Accueil</a></li>
    <li class="active"><a href="{{ route('articles') }}"><i class="fa fa-items"></i> Articles</a></li>
  </ol>
@endsection

@section('content')

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

  //Categorie @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  function updateCategorieFunction(id_categorie, libelle){
    document.getElementById('update_id_categorie').value = id_categorie;
    document.getElementById('update_libelle_categorie').value = libelle;
  }

  function deleteCategorieFunction(id_categorie,libelle){
    var go = confirm('Vos êtes sur le point d\'effacer la catégorie: "'+libelle+'".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_categorie").value = id_categorie;
      document.getElementById("formDeleteCategorie").submit();
    }
  }

  //Article @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  function updateArticleFunction(id_article, id_categorie, id_unite, code, designation, description){

    document.getElementById('update_id_article').value = id_article;
    document.getElementById('update_id_categorie_article').value = id_categorie;
    document.getElementById('update_id_unite_article').value = id_unite;
    document.getElementById('update_code_article').value = code;
    document.getElementById('update_designation_article').value = designation;
    document.getElementById('update_description_article').value = description;
  }

  function deleteArticleFunction(id_article, code, designation){
    var go = confirm('Vos êtes sur le point d\'effacer l\'élement: "' + code + ' - ' + designation + '".\n voulez-vous continuer?');
    if(go){
      document.getElementById("delete_id_article").value = id_article;
      document.getElementById("formDeleteArticle").submit();
    }
  }

</script>
@endsection
