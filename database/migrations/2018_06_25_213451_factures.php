<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Factures extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('factures', function (Blueprint $table) {
      $table->increments('id_facture');
      $table->boolean('ferme')->default(false);
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
    Schema::drop('alerts');
  }
}
