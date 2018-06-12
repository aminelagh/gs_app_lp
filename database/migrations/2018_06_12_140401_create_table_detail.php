<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetail extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('details', function (Blueprint $table) {
      $table->increments('id_detail');
      $table->string('client');
      $table->string('description');
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
    Schema::drop('details');
  }
}
