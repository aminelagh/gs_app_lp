<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MigrationCartalystSentinel extends Migration
{
  public function up()
  {
    Schema::create('activations', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->string('code');
      $table->boolean('completed')->default(0);
      $table->timestamp('completed_at')->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('persistences', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->string('code');
      $table->timestamps();
      $table->engine = 'InnoDB';
      $table->unique('code');
    });

    Schema::create('reminders', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->string('code');
      $table->boolean('completed')->default(0);
      $table->timestamp('completed_at')->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
    });

    Schema::create('roles', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug');
      $table->string('name');
      $table->text('permissions')->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
      $table->unique('slug');
    });

    Schema::create('role_users', function (Blueprint $table) {
      $table->integer('user_id')->unsigned();
      $table->integer('role_id')->unsigned();
      $table->nullableTimestamps();
      $table->engine = 'InnoDB';
      $table->primary(['user_id', 'role_id']);
    });

    Schema::create('throttle', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->unsigned()->nullable();
      $table->string('type');
      $table->string('ip')->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
      $table->index('user_id');
    });

    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('email');
      $table->string('password');
      $table->text('permissions')->nullable();
      $table->string('nom')->nullable();
      $table->string('prenom')->nullable();
      $table->datetime('last_login')->nullable();
      $table->timestamps();
      $table->engine = 'InnoDB';
      $table->unique('email');
    });
  }

  public function down()
  {
    Schema::drop('activations');
    Schema::drop('persistences');
    Schema::drop('reminders');
    Schema::drop('roles');
    Schema::drop('role_users');
    Schema::drop('throttle');
    Schema::drop('users');
  }
}
