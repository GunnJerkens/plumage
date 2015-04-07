<?php

class ProjectTableSeeder extends Seeder
{

  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {

    $id = DB::table('projects')->insert([
      'user_id'   => 1,
      'name'      => 'example',
      'is_active' => true
    ]);

    DB::table('projects_types')->insert([
      'project_id' => $id,
      'type'       => 'test-type',
      'table_name' => 'example_test-type',
      'fields'     => '[{"field_type":"text","field_name":"test_column"}]',
    ]);

    Schema::create('example_test-type', function($table)
    {
      $table->increments('id');
      $table->mediumText('test_column')->nullable();
    });

    DB::table('example_test-type')->insert([
      'test_column' => 'This is sample data.'
    ]);

  }

}
