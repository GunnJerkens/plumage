<?php

class ProjectTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run() {
    DB::table('projects')->insert([
      'name'      => 'Default Project',
      'name_adj'  => 'default-project',
      'is_active' => true
    ]);
  }

}