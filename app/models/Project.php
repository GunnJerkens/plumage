<?php

class Project extends Eloquent {

  use SoftDeletingTrait;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'projects';

  /**
   * Fillable items in the database
   *
   * @var array
   */
  protected $fillable = ['user_id', 'name', 'is_active'];

  /**
   * Create a new project and return the response
   *
   * @param string
   *
   * @return array
   */
  public static function createNewProject($user_id, $project_name) {
    $id = self::create([
      'user_id'   => $user_id,
      'name'      => $project_name,
      'is_active' => true
    ]);
    if($id) {
      $response = ['error' => false, 'message' => 'Created new project successfully.'];
    } else {
      $response = ['error' => true, 'message' => 'Project creation failed.'];
    }
    return $response;
  }

}
