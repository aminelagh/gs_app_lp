<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model{
  protected $table = 'unites';

  protected $primaryKey = 'id_unite';

  protected $fillable = ['id_unite', 'libelle',
  'created_at', 'updated_at'];
}
