<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Client extends Model
{
  protected $table = 'clients';

  protected $primaryKey = 'id_client';

  protected $fillable = ['id_client', 'nom', 'prenom', 'email', 'tel', 'description',
  'created_at', 'updated_at'];

}
