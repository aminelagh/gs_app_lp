<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detail extends Model
{
  protected $table = 'details';

  protected $primaryKey = 'id_detail';

  protected $fillable = ['id_detail', 'client', 'description',
  'created_at', 'updated_at'];

  public static function getNextID(){
    $lastRecord = DB::table('details')->orderBy('id_detail', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_detail + 1);
    return $result;
  }
}
