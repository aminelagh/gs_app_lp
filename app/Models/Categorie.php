<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model{

  protected $table = 'categories';

  protected $primaryKey = 'id_categorie';

  protected $fillable = ['id_categorie', 'libelle',
  'created_at', 'updated_at'];
}
