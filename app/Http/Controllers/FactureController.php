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

}
