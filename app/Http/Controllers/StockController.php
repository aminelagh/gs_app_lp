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
use \App\Models\Stock;
use \App\Models\Transaction;
use \App\Models\Type_transaction;
use \App\Models\Transaction_article;
use \DB;

class StockController extends Controller{

  public function stock(Request $request){
    $categories = Categorie::all();
    $articles = collect(DB::select(
      "SELECT c.libelle as libelle_categorie, u.libelle as libelle_unite, a.*
      FROM articles a
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite;"
    ));
    $unites = Unite::all();
    $stockINs = collect(DB::select(
      "SELECT *FROM transactions s WHERE id_type_transaction=1;"
    ));
    $stocks = collect(DB::select(
      "SELECT s.*, a.code,a.designation,a.description,a.id_categorie,a.id_unite,a.id_categorie,a.id_unite,
      c.libelle as libelle_categorie, u.libelle as libelle_unite
      FROM stocks s
      LEFT JOIN articles a ON a.id_article=s.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite;"
    ));

    //foreach ($stocks as $item) dump($item);

    return view('user.stock')->with(compact('articles','categories','unites','stocks','stockINs'));
  }

  public function addStockIN(Request $request){
    try{
      $id_articles = $request->get('id_article');
      $quantites = $request->get('quantite');

      //verify data
      $hasData = false;
      foreach ($id_articles as $index => $id_article) {
        if($quantites[$index] != null && $quantites[$index]>0 ){
          $hasData = true;
          echo " . ";
        }
      }

      if($hasData){
        //create new Transaction
        $id_transaction = Transaction::getNextID();
        $transaction = new Transaction();
        $transaction->id_transaction = $id_transaction;
        $transaction->id_type_transaction = 1;
        $transaction->id_detail = 1;
        $transaction->save();

        foreach ($id_articles as $index => $id_article) {
          if($quantites[$index] != null && $quantites[$index]>0 ){

            $article = Article::find($id_article);
            $stock = Stock::where('id_article',$id_article)->get()->first();

            $transaction_article = new Transaction_article();
            $transaction_article->id_transaction = $id_transaction;
            $transaction_article->id_article = $id_article;
            $transaction_article->quantite = $quantites[$index];
            $transaction_article->prix = 0;
            $transaction_article->save();

            echo "$index: $id_article  ==> $quantites[$index] Article: [ $article->code, $article->designation ]";
            if($stock!=null) {
              //update existing stock $item
              $stock->quantite = $stock->quantite + $quantites[$index];
              $stock->save();
            }else{
              //create new stock item
              $newStock = new Stock();
              $newStock->id_article = $id_article;
              $newStock->quantite = $quantites[$index];
              $newStock->save();
            }
          }
        }
      }

      if($hasData) return redirect()->back()->with('alert_success',"Stock mis à jour");
      else return redirect()->back()->with('alert_warning',"Veuillez remplir le formulaire.");

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur !!!.<br>Message d'erreur: ".$e->getMessage());
    }
  }


}
