<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model{

  protected $table = 'transactions';

  protected $primaryKey = 'id_transaction';

  protected $fillable = ['id_transaction', 'id_type_transaction', 'id_client','valide',
  'created_at', 'updated_at'];

  public static function getNextID(){
    $lastRecord = DB::table('transactions')->orderBy('id_transaction', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_transaction + 1);
    return $result;
  }

  public static function getTotal($id_transaction){
    $total = collect(DB::select(
      "SELECT SUM(ta.prix*ta.quantite) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_transaction=$id_transaction;"
    ));
    return $total->first()->total;
  }

  public static function getNombreArticles($id_transaction){
    $total = collect(DB::select(
      "SELECT count(ta.id_article) as total
      FROM transactions t
      LEFT JOIN transaction_articles ta ON ta.id_transaction=t.id_transaction
      WHERE t.id_transaction=$id_transaction;"
    ));
    return $total->first()->total;
  }



}
