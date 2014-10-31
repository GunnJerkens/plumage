<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTypesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    Schema::create('projects_types', function($table) {

      $defaultTime = '1985-11-01 01:22:00';

      $table->increments('id');
      $table->integer('project_id')->references('id')->on('projects');
      $table->string('name');
      $table->string('table_name');
      $table->mediumText('fields')->nullable();
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
    Schema::drop('projects_fields');
  }

}
