<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VenteFacture extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('vente_facture', function (Blueprint $table) {
      $table->increments('id_vente_facture');
      $table->string('id_transaction');
      $table->string('id_facture');
      $table->timestamps();
      $table->engine = 'InnoDB';
    });
  }
  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('vente_facture');
  }
}
