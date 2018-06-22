<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlerts extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('alerts', function (Blueprint $table) {
      $table->increments('id_alert');
      $table->integer('id_article');
      $table->float('quantite_min',8,2);
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
