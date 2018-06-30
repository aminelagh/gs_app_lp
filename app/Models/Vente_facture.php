<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vente_facture extends Model
{
  protected $table = 'vente_facture';

  protected $primaryKey = 'id_vente_facture';

  protected $fillable = ['id_vente_facture', 'id_transaction', 'id_facture',
  'created_at', 'updated_at'];

  public static function getNextID(){
    $lastRecord = DB::table('vente_facture')->orderBy('id_vente_facture', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_vente_facture + 1);
    return $result;
  }
}
