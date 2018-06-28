<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payements extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('payements', function (Blueprint $table) {
      $table->increments('id_payement');
      $table->integer('id_facture');
      $table->float('montant');
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
    Schema::drop('payements');
  }
}
