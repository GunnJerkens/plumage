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
      'first_name' => 'Dev',
      'last_name'  => 'Team',
      'email'      => 'devteam@gunnjerkens.com',
      'password'   => 'test',
      'activated'  => true,
    ]);

    // Need to setup groups before commenting this back in
    // $admin = Sentry::findGroupByName('admin');
    // $createAdmin->addGroup($admin);

  }

}