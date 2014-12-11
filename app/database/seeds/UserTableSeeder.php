<?php

use App\Models\User;

class UserTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run() {

    $createAdmin = Sentry::createUser([
      'first_name' => 'Marty',
      'last_name'  => 'McFly',
      'email'      => 'mmcfly@hillvalley.com',
      'password'   => 'timetravel',
      'activated'  => true,
    ]);

    $admin = Sentry::findGroupByName('admin');
    $createAdmin->addGroup($admin);

  }

}