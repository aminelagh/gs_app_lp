<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Client;
use \App\Models\Facture;
use \App\Models\payement;
use \DB;
use \Exception;

class ClientController extends Controller
{
  public function clients(Request $request) {
    $title = "Clients";
    //$clients = Client::orderBy('created_at','desc')->take(2)->get();
    $clients = Client::orderBy('created_at','desc')->get();
    //$stockINsCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=1;"))->count();
    //$stockOUTsCount = collect(DB::select("SELECT *FROM transactions s WHERE id_type_transaction=2;"))->count();

    //dump($articles->count()); foreach ($articles as $item) dump($item);

    return view('user.clients')->with(compact('clients'));//->with('alert_info',"Test");
  }

  public function client($id_client, Request $request) {
    $client = Client::find($id_client);
    if($client == null){
      return redirect()->back()->withAlertInfo("Element non disponible pour le moment veullez essayer plus tard");
    }

    $title = $client->nom." ".$client->prenom;
    $factures = Facture::whereIdClient($id_client)->get();
    $payements = collect(DB::select("SELECT * FROM payements p WHERE id_facture in (SELECT id_facture FROM factures WHERE id_client=$id_client);"));

    //dump($articles->count()); foreach ($articles as $item) dump($item);

    return view('user.client')->with(compact('client','factures','payements'));//->with('alert_info',"Test");
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
