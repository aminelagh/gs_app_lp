<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Client;
use \App\Models\Facture;
use \App\Models\payement;
use \App\Models\Transaction;
use \App\Modals\Vente_facture;
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
      "SELECT t.id_transaction,t.created_at, SUM(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_client=$id_client AND t.id_transaction not in (select id_transaction FROM vente_facture)
      GROUP BY t.id_transaction,t.created_at;"
    ));

    $facturesOpen = collect(DB::select(
      "SELECT f.*
      FROM factures f
      LEFT JOIN vente_facture vf ON vf.id_facture=f.id_facture
      LEFT JOIN transactions t ON t.id_transaction=vf.id_transaction
      WHERE t.id_client=$id_client AND f.ferme!=true;"
    ));
    $payements = collect(DB::select("SELECT * FROM payements p;"));

    return view('user.client')->with(compact('client','factures','payements','ventes','facturesOpen'));
  }
  //----------------------------------------------------------------------------

  //add vente to facture (create Vente factures) -------------------------------
  public function addFacture(Request $request){
    try{
      $id_transactions = $request->get('id_transaction');
      $checked = $request->get('checked');
      dump($id_transactions);
      dump($checked);

      foreach($id_transactions as $index => $id_transaction){
        if(isset($checked[$index])){
          $transaction = Transaction::find($id_transaction);

          //create facture ......................
          $id_facture = Facture::getNextID();
          $facture = new Facture();
          $facture->id_facture = $id_facture;
          $facture->ferme = false;
          $facture->save();
          //.....................................

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
    return "Details $id_transaction";

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
      if(Facture::where('id_client',$request->id_client)->get()->first() != null){
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
