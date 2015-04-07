<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSoftDeletes extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    // Delete all soft deleted rows in the project table
    DB::table('projects')->whereNotNull('deleted_at')->delete();

    // Delete all soft deleted project types
    DB::table('projects_types')->whereNotNull('deleted_at')->delete();

    // Drop the columns
    Schema::table('projects', function($table) {
        $table->dropColumn('deleted_at');
    });
    Schema::table('projects_types', function($table) {
        $table->dropColumn('deleted_at');
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // This is not to be reversed.
  }

}
