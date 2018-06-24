<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Article;
use \App\Models\Categorie;
use \App\Models\Stock;
use \App\Models\Transaction;
use \App\Models\Transaction_article;
use \App\Models\Unite;
use \App\Models\Detail;
use \DB;
use \Exception;

class VenteController extends Controller
{
  public function annulerVente(Request $request){
    try {
      $transaction = Transaction::find($request->id_transaction);
      $transaction_articles = Transaction_article::whereIdTransaction($request->id_transaction)->get();
      //dump($transaction);
      //dump($transaction_articles);
      foreach($transaction_articles as $ta){
        $id_article = $ta->id_article;
        $quantite = $ta->quantite;

        //update Stock or create stock
        $stock = Stock::whereIdArticle($id_article)->get()->first();
        if($stock == null){
          $newStock = new Stock();
          $stock->id_article = $id_article;
          $stock->quantite = $quantite;
          $stock->save();
        }
        else{
          $stock->quantite += $quantite;
          $stock->save();
        }

      }
      //update the transactions
      $transaction->valide = false;
      $transaction->save();
      return redirect()->back()->with('alert_success',"Vente annulée.");

    } catch (Exception $e) {
      return redirect()->back()->with('alert_danger', "Erreur !!!.<br>Message d'erreur: " . $e->getMessage());
    }
  }



  //Stock vente ****************************************************************
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
        $id_detail = Detail::getNextID();
        $transaction = new Transaction();
        $transaction->id_transaction = $id_transaction;
        $transaction->id_type_transaction = 3; //vente id_type_transaction
        $transaction->id_detail = $id_detail;
        $transaction->valide = true;
        $transaction->save();

        $detail = new Detail();
        $detail->id_detail = $id_detail;
        $detail->client = $request->client;
        $detail->description = $request->description;
        $detail->save();

        foreach ($id_articles as $index => $id_article) {
          if ($quantites[$index] != null && $quantites[$index] > 0 && $prix[$index] != null && $prix[$index] > 0) {

            $article = Article::find(intval($id_article));
            $stock = Stock::where('id_article', intval($id_article))->get()->first();

            $transaction_article = new Transaction_article();
            $transaction_article->id_transaction = $id_transaction;
            $transaction_article->id_article = intval($id_article);
            $transaction_article->quantite = $quantites[$index];
            $transaction_article->prix = $prix[$index];
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
        $vente = Transaction::find($id_transaction);
        $detail = Detail::find($id_detail);
        $articles = Transaction_article::whereIdTransaction($id_transaction)->get();

        $data = [ $vente, $detail, $articles ];
        $pdf = PDF::loadView('pdf.facture', $data)->setPaper('a4', 'portrait');//->setPaper('a4', 'landscape');
        return $pdf->stream();

        return redirect()->back()->with('alert_success', "Stock mis à jour");
      } else {
        return redirect()->back()->with('alert_warning', "Veuillez remplir le formulaire.");
      }

    } catch (Exception $e) {
      return redirect()->back()->with('alert_danger', "Erreur !!!.<br>Message d'erreur: " . $e->getMessage());
      //dump($e->getMessage());
    }
  }



  public function ventes(Request $request){
    $title = "Historique des ventes";
    //quantite * prix des ventes du dernier mois
    $total_ventes_mois = collect(DB::select(
      "SELECT MONTH(t.created_at), sum(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3
      GROUP BY MONTH(t.created_at);"
    ));
    if($total_ventes_mois->count() >0 ){$total_ventes_mois = $total_ventes_mois->last()->total;}else{$total_ventes_mois = 0;}
    //quantite * prix des ventes
    $total_ventes = collect(DB::select(
      "SELECT sum(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3;"
    ));

    if($total_ventes->count() >0 ){$total_ventes = $total_ventes->last()->total;}else{$total_ventes = 0;}

    $ventes = collect(DB::select(
      "SELECT t.id_transaction, t.id_detail, t.created_at, t.valide,
      count(ta.id_transaction_article) as nombre_articles, sum(ta.prix*ta.quantite) as somme_prix
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_type_transaction=3
      GROUP BY t.id_transaction, t.id_detail, t.created_at
      ORDER BY t.created_at desc;"
    ));
    return view('user.ventes')->with(compact('ventes', 'title', 'total_ventes', 'total_ventes_mois'));
  }



  public function vente($id_transaction, Request $request){
    $stockIN = Transaction::find($id_transaction);
    if($stockIN==null){
      return redirect()->back()->with('alert_warning',"Impossible de trouver cet élément.");
    }
    else if($stockIN->id_type_transaction!=3){
      return redirect()->route("error");
      return redirect()->back()->with('alert_warning',"");
    }
    $title = "Ventes: $stockIN->created_at";
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
    //dump($transaction->id_detail);
    $detail = Detail::find($transaction->id_detail);
    //dump($detail);
    $view = view('user.vente')->with(compact('transaction', 'detail', 'title','transaction_articles'));
    if($transaction->valide == false){
      $view->with('alert_info',"Cette vente est annulée.");
    }
    return $view;
  }
  //****************************************************************************
}
