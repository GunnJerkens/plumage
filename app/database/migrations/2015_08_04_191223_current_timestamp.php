<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurrentTimestamp extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $tables = ['groups', 'projects', 'projects_types', 'users'];

    foreach($tables as $table) {
      if(Schema::hasColumn($table, 'created_at')) {
        DB::statement("ALTER TABLE `$table` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
      }
      if(Schema::hasColumn($table, 'updated_at')) {
        DB::statement("ALTER TABLE `$table` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
      }
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // This will have no reverse
  }

}
