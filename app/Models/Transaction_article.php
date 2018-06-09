<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_article extends Model
{
  protected $table = 'transaction_articles';

  protected $primaryKey = 'id_transaction_article';

  protected $fillable = ['id_transaction_article', 'id_transaction', 'id_article', 'quantite', 'prix',
  'created_at', 'updated_at'];
}
