<?php

class ProjectAccessTableSeeder extends Seeder
{

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = DB::table('users')->where('id', 2)->first();

    if($user !== null) {
      DB::table('projects_access')->insert(["project_id" => 1, "user_id" => $user->id]);
    }
  }

}
