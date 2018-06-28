<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Facture extends Model
{
  protected $table = 'factures';

  protected $primaryKey = 'id_facture';

  protected $fillable = ['id_facture', 'id_client', 'ferme',
  'created_at', 'updated_at'];


}
