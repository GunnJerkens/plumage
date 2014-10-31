<?php

class ProjectTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run() {
    DB::table('projects')->insert([
      'name'      => 'Example',
      'name_adj'  => 'example',
      'is_active' => true
    ]);
  }

}