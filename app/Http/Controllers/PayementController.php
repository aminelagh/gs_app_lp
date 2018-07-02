<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Article;
use \App\Models\Categorie;
use \App\Models\Stock;
use \App\Models\Transaction;
use \App\Models\Transaction_article;
use \App\Models\Client;
use \App\Models\Payement;
use \App\Models\Facture;
use \App\Models\Vente_facture;
use \DB;
use \Exception;

class PayementController extends Controller
{
  public function addPayement(Request $request){
    try{
      $result = redirect()->back()->with('alert_success',"Payement effectué");

      if($request->has('montant') && $request->montant > 0){
        $item = new Payement();
        $item->id_facture = $request->id_facture;
        $item->montant = $request->montant;
        $item->save();
      }

      // update Facture to ferme if paid for ...................................
      $data = collect(DB::select(
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
        WHERE f.id_facture=".$request->id_facture."
        GROUP BY f.id_facture, f.created_at, f.ferme;"
      ));
      $laFacture = $data->first();
      if($laFacture->montant == $laFacture->paye){
        $facture = Facture::find($request->id_facture);
        $facture->ferme = true;
        $facture->save();
        $result = $result->with('alert_info',"Facture complètement payée");
      }
      //........................................................................

    }catch(Exception $e){
      return redirect()->back()->withInput()->with('alert_danger',"Erreur de payement.<br>Message d'erreur: ".$e->getMessage().".");
    }
    return $result;
  }
}
