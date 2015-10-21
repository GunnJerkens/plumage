<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsProjectAccessPermissions extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('projects_access', function($table) {
      $table->boolean('can_add_users')->default(false);
      $table->boolean('can_edit')->default(false);
      $table->boolean('can_delete')->default(false);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('projects_access', function($table) {
        $table->dropColumn('can_add_users');
        $table->dropColumn('can_edit');
        $table->dropColumn('can_delete');
    });
  }

}
