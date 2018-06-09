<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  
  protected $table = 'stocks';

  protected $primaryKey = 'id_stock';

  protected $fillable = ['id_stock', 'id_article', 'quantite',
  'created_at', 'updated_at'];

  /*
  static function getNextID(){
  $lastRecord = DB::table('articles')->orderBy('id_article', 'desc')->first();
  $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
  return $result;
}

static function exists($id_article){
$article = Article::find($id_article);
return $article == null ? false : true;
}*/


}
