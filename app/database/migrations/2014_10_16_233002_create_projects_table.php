<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    Schema::create('projects', function($table) {

      $defaultTime = '1985-11-01 01:22:00';

      $table->increments('id');
      $table->integer('user_id')->references('id')->on('users');
      $table->string('name');
      $table->boolean('is_active')->default(false);
      $table->dateTime('created_at')->default($defaultTime);
      $table->dateTime('updated_at')->default($defaultTime);
      $table->softDeletes()->nullable();

    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('projects');
  }

}
