<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{

  public function annulerVente(Request $request){
    dump($request->all());
    $transaction = Transaction::find($request->id_transaction);
    $transaction_articles = Transaction_article::whereIdTransaction($request->id_transaction)->get();
    dump($transaction);
    dump($transaction_articles);
    foreach($transaction_articles as $ta){
      $id_article = $ta->id_article;
      $quantite = $ta->quantite;

      //update Stock
      $stock = Stock::whereIdArticle($id_article)->get()->first();
      $stock->quantite += $quantite;
      $stock->save();
      //echo "Stock: $stock->id_stock, $stock->id_article, $stock->quantite <br>";
    }
    //update the transactions
    //$transaction->valide = false;
    $transaction->save();

  }
}
