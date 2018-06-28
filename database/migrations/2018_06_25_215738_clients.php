<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clients extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('clients', function (Blueprint $table) {
      $table->increments('id_client');
      $table->string('nom');
      $table->string('prenom')->nullable();
      $table->string('email')->nullable();
      $table->string('tel')->nullable();
      $table->string('description')->nullable();
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
    Schema::drop('clients');
  }
}
