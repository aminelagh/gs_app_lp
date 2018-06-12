<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Article;
use \App\Models\Categorie;
use \App\Models\Stock;
use \App\Models\Transaction;
use \App\Models\Transaction_article;
use \App\Models\Unite;
use \DB;
use \Exception;

class StockController extends Controller{

  public function stock(Request $request)  {
    $title = "Stock";
    $categories = Categorie::all();
    $articles = collect(DB::select(
      "SELECT c.libelle as libelle_categorie, u.libelle as libelle_unite, a.*, s.quantite
      FROM articles a
      LEFT JOIN stocks s ON s.id_article=a.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite;"
    ));
    $unites = Unite::all();
    $stockINsCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=1;"))->count();
    $stockOUTsCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=2;"))->count();
    $ventesCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=3;"))->count();
    $stocks = collect(DB::select(
      "SELECT s.*, a.code,a.designation,a.description,a.id_categorie,a.id_unite,a.id_categorie,a.id_unite,
      c.libelle as libelle_categorie, u.libelle as libelle_unite
      FROM stocks s
      LEFT JOIN articles a ON a.id_article=s.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite;"
    ));

    //dump($articles->count()); foreach ($articles as $item) dump($item);

    return view('user.stock')->with(compact('articles', 'categories', 'unites', 'stocks', 'stockINsCount', 'stockOUTsCount', 'title', 'ventesCount'));
  }

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
        //create new Transaction
        $id_transaction = Transaction::getNextID();
        $transaction = new Transaction();
        $transaction->id_transaction = $id_transaction;
        $transaction->id_type_transaction = 1;
        $transaction->id_detail = 1;
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
              $stock->quantite = $stock->quantite + $quantites[$index];
              $stock->save();

              //echo "update Stock<br>";dump($stock);
            } else {
              //create new stock item
              $newStock = new Stock();
              $newStock->id_article = intval($id_article);
              $newStock->quantite = $quantites[$index];
              $newStock->save();
              //echo "new Stock<br>";dump($newStock);
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
        $transaction->id_detail = 1;
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

  public function addVente(Request $request) {
    try {
      $id_articles = $request->get('id_article');
      $quantites = $request->get('quantite');
      $prix = $request->get('prix');

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
        $transaction->id_type_transaction = 3; //stock out id_type_transaction
        $transaction->id_detail = 1;
        $transaction->save();

        foreach ($id_articles as $index => $id_article) {
          if ($quantites[$index] != null && $quantites[$index] > 0 && $prix[$index] != null && $prix[$index] > 0) {

            $article = Article::find(intval($id_article));
            $stock = Stock::where('id_article', intval($id_article))->get()->first();

            $transaction_article = new Transaction_article();
            $transaction_article->id_transaction = $id_transaction;
            $transaction_article->id_article = intval($id_article);
            $transaction_article->quantite = $quantites[$index];
            $transaction_article->prix = 0;
            $transaction_article->save();

            if ($stock != null) {
              //update existing stock $item
              $stock->quantite = $stock->quantite - $quantites[$index];
              $stock->save();
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
    $unites = Unite::all();
    $stockINs = collect(DB::select(
      "SELECT t.id_transaction, t.id_detail, t.created_at,
      count(ta.id_transaction_article) as nombre_articles
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=1
      GROUP BY t.id_transaction, t.id_detail, t.created_at;"
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
      WHERE ta.id_transaction=$id_transaction;"
    ));
    $transaction = Transaction::find($id_transaction);

    //foreach ($transaction_articles as $item) dump($item);

    return view('user.stockIN')->with(compact('articles','transaction', 'title','transaction_articles'));
  }

}
