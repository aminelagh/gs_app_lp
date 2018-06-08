<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use \App\Models\categorie;

class Article extends Model
{
  protected $table = 'articles';

  protected $primaryKey = 'id_article';

  protected $fillable = ['id_article', 'id_categorie', 'id_unite',
  'code', 'designation', 'description',
  'created_at', 'updated_at'];

  static function getNextID(){
    $lastRecord = DB::table('articles')->orderBy('id_article', 'desc')->first();
    $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
    return $result;
  }

  static function exists($id_article){
    $article = Article::find($id_article);
    return $article == null ? false : true;
  }


}
