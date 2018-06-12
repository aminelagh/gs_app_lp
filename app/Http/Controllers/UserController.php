<?php

namespace App\Http\Controllers;


use Closure;
use \Exception;
use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Unite;
use \App\Models\Categorie;
use \App\Models\Article;
use \DB;
use App\Models\Stock;


class UserController extends Controller
{
  public function accueil(Request $request){
    $categories = Categorie::all();
    $stocksNumber = Stock::all()->count();
    $articles = collect(DB::select(
      "SELECT c.libelle as libelle_categorie, a.*
      FROM articles a
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie;"
    ));
    $unites = Unite::all();
    return view('user.accueil')->with(compact('articles','categories','unites','stocksNumber'));
  }

  //CRUD Categorie @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  public function addCategorie(Request $request){
    try{
      $item = new Categorie();
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element créé");
  }

  public function updateCategorie(Request $request){
    try{
      $item = Categorie::find($request->id_categorie);
      $item->libelle = $request->libelle;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de modification de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element Modifiée");
  }

  public function deleteCategorie(Request $request){
    try{
      $item = Categorie::find($request->id_categorie);
      $item->delete();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element supprimée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  //CRUD Article @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  public function addArticle(Request $request){
    try{
      //dd($request->all());
      $item = new Article();
      $item->id_categorie = $request->id_categorie;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->description = $request->description;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Elément créé");
  }

  public function updateArticle(Request $request){
    try{
      $item = Article::find($request->id_article);
      $item->id_categorie = $request->id_categorie;
      $item->id_unite = $request->id_unite;
      $item->code = $request->code;
      $item->designation = $request->designation;
      $item->description = $request->description;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de modification de l'élement.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element Modifiée");
  }

  public function deleteArticle(Request $request){
    try{
      $item = Article::find($request->id_article);
      $item->delete();
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element supprimée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  public function categorie($id_categorie, Request $request){
    return "Categorie: $id_categorie";
  }


}
