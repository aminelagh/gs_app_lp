<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Payement extends Model
{
  protected $table = 'payements';

  protected $primaryKey = 'id_payement';

  protected $fillable = ['id_payement', 'id_facture', 'montant',
  'created_at', 'updated_at'];

}
