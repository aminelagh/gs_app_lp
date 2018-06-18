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
    document.getElementById("delete_id_article").value = id_categorie;
    document.getElementById("formDeleteArticle").submit();
  }
}
