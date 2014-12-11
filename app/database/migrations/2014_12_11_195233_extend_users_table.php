<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendUsersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    Schema::table('users', function($table) {
      $table->longText('access')->nullable();
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {

    Schema::table('users', function($table) {
      $table->dropColumn('access');
    });

  }

}
