<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabase extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->increments('id_categorie');
      $table->string('libelle');
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('unites', function (Blueprint $table) {
      $table->increments('id_unite');
      $table->string('libelle');
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('articles', function (Blueprint $table) {
      $table->increments('id_article');
      $table->integer('id_categorie');
      $table->integer('id_unite')->nullable();
      $table->string('code');
      $table->string('designation');
      $table->string('description')->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('stocks', function (Blueprint $table) {
      $table->increments('id_stock');
      $table->integer('id_article');
      $table->float('quantite',8,2);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('type_transactions', function (Blueprint $table) {
      $table->increments('id_type_transaction');
      $table->string('libelle');
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('transactions', function (Blueprint $table) {
      $table->increments('id_stock');
      $table->integer('id_type_transaction');
      $table->integer('id_detail');
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('transation_articles', function (Blueprint $table) {
      $table->increments('id_transaction_article');
      $table->integer('id_transaction');
      $table->integer('id_article');
      $table->float('quantite',8,2);
      $table->float('prix',8,2);
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    //details
    //alerts: article quantite
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('categories');
    Schema::drop('unites');
    Schema::drop('articles');
    Schema::drop('stocks');
    Schema::drop('type_transactions');
    Schema::drop('transactions');
    Schema::drop('transation_articles');
  }
}
