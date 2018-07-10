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
use \Exception;

class ClientController extends Controller
{
  // list clients --------------------------------------------------------------
  public function clients(Request $request) {
    $title = "Clients";
    $clients = Client::orderBy('created_at','desc')->get();
    return view('user.clients')->with(compact('clients'));//->with('alert_info',"Test");
  }

  //client dash ----------------------------------------------------------------
  public function client($id_client, Request $request) {
    $client = Client::find($id_client);
    if($client == null){
      return redirect()->back()->withAlertInfo("Element non disponible pour le moment veullez essayer plus tard");
    }

    $title = $client->nom." ".$client->prenom;
    $ventes = collect(DB::select(
      "SELECT t.id_transaction,t.created_at, COUNT(ta.id_article) as nombre_articles, SUM(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_client=$id_client AND t.id_transaction not in (select id_transaction FROM vente_facture)
      GROUP BY t.id_transaction,t.created_at;"
    ));

    $facturesOpen = collect(DB::select(
      "SELECT f.id_facture, f.created_at, f.ferme,
      COUNT(DISTINCT vf.id_vente_facture) as nombre_ventes,
      ROUND(SUM(DISTINCT ta.quantite*ta.prix), 2) as montant,
      ROUND(COUNT(DISTINCT p.id_payement)*SUM(montant)/count(p.id_payement), 2) as paye,
      ROUND((SUM(DISTINCT ta.quantite*ta.prix)) - (COUNT(DISTINCT p.id_payement)*SUM(montant)/count(p.id_payement)), 2) as reste,
      SUM(DISTINCT p.montant) as paye2,
      SUM(p.montant) as paye3
      FROM factures f
      LEFT JOIN vente_facture vf ON vf.id_facture=f.id_facture
      LEFT JOIN transactions t ON t.id_transaction=vf.id_transaction
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      LEFT JOIN payements p ON p.id_facture=f.id_facture
      WHERE t.id_client=$id_client AND f.ferme!=true
      GROUP BY f.id_facture, f.created_at, f.ferme;"
    ));
    $facturesClosed = collect(DB::select(
      "SELECT f.id_facture, f.created_at, f.ferme,
      COUNT(DISTINCT vf.id_vente_facture) as nombre_ventes,
      ROUND(SUM(DISTINCT ta.quantite*ta.prix), 2) as montant,
      ROUND(COUNT(DISTINCT p.id_payement)*SUM(montant)/count(p.id_payement), 2) as paye,
      ROUND((SUM(DISTINCT ta.quantite*ta.prix)) - (COUNT(DISTINCT p.id_payement)*SUM(montant)/count(p.id_payement)), 2) as reste,
      SUM(DISTINCT p.montant) as paye2,
      SUM(p.montant) as paye3
      FROM factures f
      LEFT JOIN vente_facture vf ON vf.id_facture=f.id_facture
      LEFT JOIN transactions t ON t.id_transaction=vf.id_transaction
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      LEFT JOIN payements p ON p.id_facture=f.id_facture
      WHERE t.id_client=$id_client AND f.ferme=true
      GROUP BY f.id_facture, f.created_at, f.ferme;"
    ));
    //foreach ($facturesOpen as $item ) dump($item);

    //$payements = collect(DB::select("SELECT * FROM payements p;"));

    return view('user.client')->with(compact('client','factures','payements','ventes','facturesOpen', 'facturesClosed'));
  }
  //----------------------------------------------------------------------------

  //add vente to facture (create Vente factures) -------------------------------
  public function addFacture(Request $request){
    try{
      $hasData = false;
      $id_transactions = $request->get('id_transaction');
      $checked = $request->get('checked');

      //check if there is data to handel
      foreach($id_transactions as $index => $id_transaction){
        if(isset($checked[$index]) && $checked[$index] == $index){
          $hasData = true;
        }
      }
      if(!$hasData){
        return redirect()->back()->with('alert_warning',"Veuillez choisir au moins une vente afin de creer la facture.");
      }

      //create facture ......................
      $id_facture = Facture::getNextID();
      $facture = new Facture();
      $facture->id_facture = $id_facture;
      $facture->ferme = false;
      $facture->save();
      //.....................................
      foreach($id_transactions as $index => $id_transaction){
        if(isset($checked[$index]) && $checked[$index] == $index){
          $hasData = true;
          $transaction = Transaction::find($id_transaction);
          // create vente_facture ...............
          $vente_facture = new Vente_facture();
          $vente_facture->id_transaction = $id_transaction;
          $vente_facture->id_facture = $id_facture;
          $vente_facture->save();
          //.....................................
        }
      }


    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de la facture.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Facture créée");
  }
  //----------------------------------------------------------------------------

  public function detailsVente($id_transaction){
    $transaction = Transaction::find($id_transaction);
    $title = "Ventes: $transaction->created_at";
    $transaction_articles = collect(DB::select(
      "SELECT ta.*, a.code,a.designation,a.description,
      c.libelle as libelle_categorie,c.id_categorie, u.libelle as libelle_unite
      FROM transaction_articles ta
      LEFT JOIN articles a ON a.id_article=ta.id_article
      LEFT JOIN categories c ON c.id_categorie=a.id_categorie
      LEFT JOIN unites u ON u.id_unite=a.id_unite
      WHERE ta.id_transaction=$id_transaction;"
    ));

    return view('user.detailsVente')->with(compact('transaction','transaction_articles'));//->with('alert_info',"Test");

  }


  //CRUD Client @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  public function addClient(Request $request){
    try{
      $item = new Client();
      $item->nom = $request->nom;
      $item->prenom = $request->prenom;
      $item->email = $request->email;
      $item->tel = $request->tel;
      $item->description = $request->description;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de création de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Elément créé");
  }
  public function updateClient(Request $request){
    try{
      $item = Client::find($request->id_client);
      $item->nom = $request->nom;
      $item->prenom = $request->prenom;
      $item->email = $request->email;
      $item->tel = $request->tel;
      $item->description = $request->description;
      $item->save();
    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de modification de l'élement.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element Modifié");
  }
  public function deleteClient(Request $request){
    try{
      if(Transaction::where('id_client',$request->id_client)->get()->first() != null){
        return redirect()->back()->with('alert_warning',"Élément utilisé ailleurs, donc impossible de le supprimer");
      }
      else{
        $item = Client::find($request->id_client);
        $item->delete();
      }
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur de suppression de l'élément.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return redirect()->back()->with('alert_success',"Element supprimée");
  }
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
}
