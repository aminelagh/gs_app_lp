<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Facture extends Model
{
  protected $table = 'factures';

  protected $primaryKey = 'id_facture';

  protected $fillable = ['id_facture', 'ferme',
  'created_at', 'updated_at'];


  public static function getNextID(){
    $lastRecord = DB::table('factures')->orderBy('id_facture', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_facture + 1);
    return $result;
  }


}
