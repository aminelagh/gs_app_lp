<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Client;
use \App\Models\Facture;
use \App\Models\payement;
use \App\Models\Transaction;
use \App\Models\Vente_facture;
use \App\Models\Transaction_article;
use \DB;
use \PDF;
use \Exception;

class FactureController extends Controller
{
  public function facture($id_facture, Request $request) {
    $title = "Clients";
    $facture = Facture::find($id_facture);
    $payements = payement::whereIdFacture($id_facture)->get();
    dump($facture);
    dump($payements);

    return 4;
    return view('user.facture')->with(compact('facture'));//->with('alert_info',"Test");
  }


  public function printFacture(Request $request){
    try{
      //Facture
      $id_facture = $request->id_facture;
      $facture = collect(DB::select("SELECT * FROM factures WHERE id_facture=$id_facture"))->first();
      $vente_facture = Vente_facture::whereIdFacture($id_facture)->get();

      //ventes
      $transactions = collect([]);
      $id_transactions = "";
      $id_t = -1;
      $last = count($vente_facture);
      $i=0;
      foreach ($vente_facture as $vf) {
        $i++;
        $id_trans = $vf->id_transaction;
        $whereId_articles = $id_trans ;
        $transaction = collect(DB::select("SELECT * FROM transactions WHERE id_transaction=$id_trans"))->first();
        $transactions->push($transaction);
        if($last != $i) $id_transactions = "$id_trans , $id_transactions";
        else $id_transactions = "$id_transactions $id_trans";
        $id_t = $id_trans;
      }

      //Client
      $client = Client::find($transaction->id_client);

      //trans_articles
      /*$query = "SELECT ta.id_article,a.code,a.designation, SUM(ta.prix*ta.quantite) as montant
      FROM transaction_articles ta
      LEFT JOIN articles a ON a.id_article=ta.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      WHERE id_transaction in ($id_transactions)
      GROUP BY ta.id_article,a.code,a.designation";*/

      //tt les articles des ventes
      $query = "SELECT ta.id_article,a.code,a.designation,ta.prix, ta.quantite, (ta.prix*ta.quantite) as montant
      FROM transaction_articles ta
      LEFT JOIN articles a ON a.id_article=ta.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      WHERE id_transaction in ($id_transactions)";

      $articles = collect(DB::select($query));

      //Montant Total
      $total = 0;
      foreach ($articles as $item) $total += $item->montant;

      //print pdf:
      $pdf = PDF::loadView('pdf.facture', compact('articles','facture','total','client') )->setPaper('a4', 'portrait');//->setPaper('a4', 'landscape');
      return $pdf->download('facture.pdf');

    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur d'impession de la facture.<br>Message d'erreur: ".$e->getMessage());
    }


  }

}
