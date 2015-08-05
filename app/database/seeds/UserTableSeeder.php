<?php

use App\Models\User;

class UserTableSeeder extends Seeder
{

  /**
   * Class vars
   *
   * @var $faker object
   */
  private $faker, $seed;

  /**
   * Constructor
   */
  function __construct()
  {
    $this->faker = \Faker\Factory::create();
    $this->seed  = Config::get('app.seed_size');
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
    //Groups
    $admin = Sentry::findGroupByName('admin');
    $user  = Sentry::findGroupByName('user');

    // Creates our sole admin user
    $createAdmin = Sentry::createUser([
      'first_name' => 'Marty',
      'last_name'  => 'McFly',
      'email'      => 'mmcfly@hillvalley.com',
      'password'   => 'password',
      'activated'  => true,
    ]);
    $createAdmin->addGroup($admin);

    // Creates a set of random non admin users
    for($i=1;$i<=$this->seed;$i++) {
      $createUser = Sentry::createUser([
        'first_name' => $this->faker->firstName,
        'last_name'  => $this->faker->lastName,
        'email'      => $this->faker->email,
        'password'   => 'password',
        'activated'  => true,
      ]);
      $createUser->addGroup($user);
    }
  }

}
