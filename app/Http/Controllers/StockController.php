<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Article;
use \App\Models\Categorie;
use \App\Models\Stock;
use \App\Models\Transaction;
use \App\Models\Transaction_article;
use \App\Models\Client;
use \DB;
use \Exception;

class StockController extends Controller{

  public function stock(Request $request) {
    $title = "Stock";
    $articles = collect(DB::select(
      "SELECT c.libelle as libelle_categorie, u.libelle as libelle_unite, a.*, s.quantite
      FROM articles a
      LEFT JOIN stocks s ON s.id_article=a.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite;"
    ));

    //stats
    $stockINsCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=1;"))->count();
    $stockOUTsCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=2;"))->count();
    $ventesCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=3;"))->count();

    $stocks = collect(DB::select(
      "SELECT s.*, a.code,a.designation,a.description,a.id_categorie,a.id_unite,a.id_categorie,a.id_unite,
      c.libelle as libelle_categorie, u.libelle as libelle_unite
      FROM stocks s
      LEFT JOIN articles a ON a.id_article=s.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      ORDER BY s.updated_at asc;"
    ));

    //for stockOuts or ventes
    $stocksForOut = collect(DB::select(
      "SELECT s.*, a.code,a.designation,a.description,a.id_categorie,a.id_unite,a.id_categorie,a.id_unite,
      c.libelle as libelle_categorie, u.libelle as libelle_unite
      FROM stocks s
      LEFT JOIN articles a ON a.id_article=s.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      WHERE s.quantite != 0
      ORDER BY s.updated_at asc;"
    ));
    $clients = Client::all();
    //dump($stocks);dump($stocksForOut);
    //dump($articles->count()); foreach ($articles as $item) dump($item);

    return view('user.stock')->with(compact('articles', 'stocks','stocksForOut' , 'stockINsCount', 'stockOUTsCount', 'title', 'ventesCount', 'clients'));
  }

  //Stock in *******************************************************************
  public function addStockIN(Request $request) {
    try {
      $id_articles = $request->get('id_article');
      $quantites = $request->get('quantite');

      //verify data
      $hasData = false;
      foreach ($id_articles as $index => $id_article) {
        if ($quantites[$index] != null && $quantites[$index] > 0) {
          $hasData = true;
        }
      }
      if ($hasData) {
        //create new Transaction ...........................
        $id_transaction = Transaction::getNextID();
        $transaction = new Transaction();
        $transaction->id_transaction = $id_transaction;
        $transaction->id_type_transaction = 1;
        $transaction->valide = true;
        $transaction->save();
        //.................................................
        foreach ($id_articles as $index => $id_article) {
          if ($quantites[$index] != null && $quantites[$index] > 0) {

            $article = Article::find(intval($id_article));
            $stock = Stock::where('id_article', intval($id_article))->get()->first();

            //new Transaction article .........................
            $transaction_article = new Transaction_article();
            $transaction_article->id_transaction = $id_transaction;
            $transaction_article->id_article = intval($id_article);
            $transaction_article->quantite = $quantites[$index];
            $transaction_article->prix = 0;
            $transaction_article->save();
            //.................................................
            //check if stock item exist
            if ($stock != null) {
              //update existing stock $item ...........................
              $stock->quantite = $stock->quantite + $quantites[$index];
              $stock->save();
              //.................................................
            } else {
              //create new stock item ..........................
              $newStock = new Stock();
              $newStock->id_article = intval($id_article);
              $newStock->quantite = $quantites[$index];
              $newStock->save();
              //.................................................
            }
          }
        }
      }

      if ($hasData) {
        return redirect()->back()->with('alert_success', "Stock mis à jour");
      } else {
        return redirect()->back()->with('alert_warning', "Veuillez remplir le formulaire.");
      }

    } catch (Exception $e) {
      return redirect()->back()->with('alert_danger', "Erreur !!!.<br>Message d'erreur: " . $e->getMessage());
      //dump($e->getMessage());
    }
  }

  public function stockINs(Request $request){
    $title = "Historique des entrées de stock";
    $stockINs = collect(DB::select(
      "SELECT t.id_transaction, t.created_at,
      count(ta.id_transaction_article) as nombre_articles
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=1 AND t.valide!=false
      GROUP BY t.id_transaction, t.created_at
      ORDER BY t.created_at desc;"
    ));
    //foreach ($stockINs as $item) dump($item);
    return view('user.stockINs')->with(compact('articles', 'unites', 'stockINs', 'title'));
  }

  public function stockIN($id_transaction, Request $request){
    $stockIN = Transaction::find($id_transaction);
    if($stockIN==null){
      return redirect()->back()->with('alert_warning',"Impossible de trouver cet élément.");
    }
    else if($stockIN->id_type_transaction!=1){
      return redirect()->route("error");
      return redirect()->back()->with('alert_warning',"");
    }
    $title = "Entrées de stock: $stockIN->created_at";
    $transaction_articles = collect(DB::select(
      "SELECT ta.*, a.code,a.designation,a.description,
      c.libelle as libelle_categorie,c.id_categorie, u.libelle as libelle_unite
      FROM transaction_articles ta
      LEFT JOIN articles a ON a.id_article=ta.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      LEFT JOIN stocks s ON s.id_article=ta.id_article
      WHERE ta.id_transaction=$id_transaction;"
    ));
    $transaction = Transaction::find($id_transaction);
    return view('user.stockIN')->with(compact('articles','transaction', 'title','transaction_articles'));
  }
  //****************************************************************************

  //Stock out ******************************************************************
  public function addStockOUT(Request $request) {
    try {
      $id_articles = $request->get('id_article');
      $quantites = $request->get('quantite');
      //verify data
      $hasData = false;
      foreach ($id_articles as $index => $id_article) {
        if ($quantites[$index] != null && $quantites[$index] > 0) {
          $hasData = true;
        }
      }
      if ($hasData) {
        //create new Transaction
        $id_transaction = Transaction::getNextID();
        $transaction = new Transaction();
        $transaction->id_transaction = $id_transaction;
        $transaction->id_type_transaction = 2; //stock out id_type_transaction
        $transaction->valide = true;
        $transaction->save();

        //dump($transaction);
        foreach ($id_articles as $index => $id_article) {
          if ($quantites[$index] != null && $quantites[$index] > 0) {

            $article = Article::find(intval($id_article));
            $stock = Stock::where('id_article', intval($id_article))->get()->first();

            $transaction_article = new Transaction_article();
            $transaction_article->id_transaction = $id_transaction;
            $transaction_article->id_article = intval($id_article);
            $transaction_article->quantite = $quantites[$index];
            $transaction_article->prix = 0;
            $transaction_article->save();

            //dump($transaction_article);
            if ($stock != null) {
              //update existing stock $item
              $stock->quantite = $stock->quantite - $quantites[$index];
              $stock->save();

              //echo "update Stock<br>";dump($stock);
            } else {

            }
          }
        }
      }

      if ($hasData) {
        return redirect()->back()->with('alert_success', "Stock mis à jour");
      } else {
        return redirect()->back()->with('alert_warning', "Veuillez remplir le formulaire.");
      }

    } catch (Exception $e) {
      return redirect()->back()->with('alert_danger', "Erreur !!!.<br>Message d'erreur: " . $e->getMessage());
      //dump($e->getMessage());
    }
  }

  public function stockOUTs(Request $request){
    $title = "Historique des sorties de stock";
    $stockOUTs = collect(DB::select(
      "SELECT t.id_transaction, t.created_at,
      count(ta.id_transaction_article) as nombre_articles
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=2
      GROUP BY t.id_transaction, t.created_at;"
    ));
    //foreach ($stockINs as $item) dump($item);
    return view('user.stockOUTs')->with(compact('stockOUTs', 'title'));
  }

  public function stockOUT($id_transaction, Request $request){
    $stockIN = Transaction::find($id_transaction);
    if($stockIN==null){
      return redirect()->back()->with('alert_warning',"Impossible de trouver cet élément.");
    }
    else if($stockIN->id_type_transaction!=2){
      return redirect()->route("error");
      return redirect()->back()->with('alert_warning',"");
    }
    $title = "Sorties de stock: $stockIN->created_at";
    $transaction_articles = collect(DB::select(
      "SELECT ta.*, a.code,a.designation,a.description,
      c.libelle as libelle_categorie,c.id_categorie, u.libelle as libelle_unite
      FROM transaction_articles ta
      LEFT JOIN articles a ON a.id_article=ta.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      WHERE ta.id_transaction=$id_transaction;"
    ));
    $transaction = Transaction::find($id_transaction);
    return view('user.stockOUT')->with(compact('transaction', 'title','transaction_articles'));
  }
  //****************************************************************************
}
