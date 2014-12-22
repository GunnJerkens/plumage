<?php

class GroupTableSeeder extends Seeder
{

  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
    $admin = Sentry::createGroup([
      'name'        => 'admin',
      'permissions' => [
        'manage'          => 1,
      ]
    ]);

    $user = Sentry::createGroup([
      'name' => 'user',
      'permissions' => []
    ]);
  }

}
