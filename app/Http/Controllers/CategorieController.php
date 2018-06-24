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
use App\Models\Transaction;
use App\Models\transaction_article;

class CategorieController extends Controller
{
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
      if(Article::where('id_categorie',$request->id_categorie)->get()->first() != null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer");
      }
      else{
        $item = Categorie::find($request->id_categorie);
        $item->delete();
      }
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element supprimée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
