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

class UserController extends Controller{

  public function accueil(Request $request){
    $categories = Categorie::all();
    $articles = collect(DB::select("SELECT c.libelle as libelle_categorie, a.* FROM articles a LEFT JOIN categories c ON c.id_categorie=a.id_categorie;"));
    $unites = Unite::all();
    $stocksNumber = collect(DB::select("SELECT count(*) as nombre FROM stocks s where quantite>0 ;"))->first()->nombre;
    $total_ventes_mois = collect(DB::select(
      "SELECT MONTH(t.created_at), sum(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3
      GROUP BY MONTH(t.created_at);"
    ));
    if($total_ventes_mois->count()>0) {$total_ventes_mois = $total_ventes_mois->last()->total;}

    //quantite * prix des ventes
    $total_ventes = collect(DB::select(
      "SELECT sum(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3;"
    ));
    if($total_ventes->count()>0) $total_ventes = $total_ventes->last()->total;

    $ventesByYear = collect(DB::select(
      "SELECT YEAR(t.created_at) AS year, sum(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3
      GROUP BY YEAR(t.created_at)
      ORDER BY YEAR(t.created_at) asc;"
    ));

    $ventesByMonth = collect(DB::select(
      "SELECT MONTH(t.created_at) AS month,YEAR(t.created_at) AS year, sum(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3
      GROUP BY MONTH(t.created_at),YEAR(t.created_at)
      ORDER BY YEAR(t.created_at),MONTH(t.created_at) asc;"
    ));

    $articlesParCategorie = collect(DB::select(
      "SELECT C.libelle as libelle_categorie, count(s.id_article) as nombre_articles
      FROM categories c
      LEFT JOIN articles a ON a.id_categorie=c.id_categorie
      LEFT JOIN stocks s ON s.id_article=a.id_article
      GROUP BY c.libelle;"
    ));
    return view('user.accueil')->with(compact('articles','categories','unites','stocksNumber','total_ventes','total_ventes_mois','ventesByYear','articlesParCategorie', 'ventesByMonth'));
  }


  public function articles(Request $request){
    $categories = Categorie::all();
    $articles = collect(DB::select("SELECT c.libelle as libelle_categorie, a.* FROM articles a LEFT JOIN categories c ON c.id_categorie=a.id_categorie;"));
    $unites = Unite::all();

    return view('user.articles')->with(compact('articles','categories','unites','stocksNumber','total_ventes','total_ventes_mois','ventesByYear','articlesParCategorie', 'ventesByMonth'));
  }


  public function categorie($id_categorie, Request $request){
    return redirect()->back()->with('alert_info',"la page demandée n'est pas encore mise en place.");
    $categorie = Categorie::find($id_categorie);
    $articles = collect(DB::select("SELECT c.libelle as libelle_categorie, a.* FROM articles a LEFT JOIN categories c ON c.id_categorie=a.id_categorie WHERE c.id_categorie=$id_categorie ORDER BY created_at desc;"));
    return view('user.categorie')->with(compact('articles','categorie','unites','stocksNumber','total_ventes','total_ventes_mois'));
  }


}
