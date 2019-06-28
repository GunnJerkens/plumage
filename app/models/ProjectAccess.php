<?php

class ProjectAccess extends Eloquent
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'projects_access';

  /**
   * Fillable items in the database
   *
   * @var array
   */
  protected $fillable = ['project_id', 'user_id', 'can_add_users', 'can_edit', 'can_delete'];

  /**
   * Appendable items to the object on retrieval
   *
   * @var array
   */
  protected $appends = ['project_name', 'user_email'];

  /**
   * Disable the eloquent timestamps
   *
   * @var bool
   */
  public $timestamps = false;

  /**
   * Gets the project name and appends it to the model dynamically
   *
   * @return string
   */
  public function getProjectNameAttribute()
  {
    $project = Project::where('id', $this->project_id)->first();
    if (is_object($project)) {
      return $project->name;
    } else {
      return 'false';
    }
  }

  /**
   * Gets the user email and appends it to the model dynamically
   *
   * @return string
   */
  public function getUserEmailAttribute()
  {
    $user = User::where('id', $this->user_id)->first();
    return $user->email;
  }

  /**
   * Returns an array of projects the user has access
   *
   * @param $user_id integer
   *
   * @return array|false
   */
  public static function getUserProjects($user_id)
  {
    $projects = self::where('user_id', $user_id)->get();

    if($projects === null) {
      return false;
    }

    $projectIds = [];

    foreach($projects as $project) {
      if($project->user_id === $user_id) {
        $projectIds[] = $project->project_id;
      }
    }

    return (sizeof($projectIds) > 0) ? $projectIds : false;
  }

  /**
   * Returns a project access object else creates one
   *
   * @param $user_id integer
   *
   * @param $project_id integer
   *
   * @return object
   */
  public static function getUserProjectAccess($user_id, $project_id)
  {
    $projectAccess = self::where('project_id', $project_id)->where('user_id', $user_id)->first();

    if($projectAccess === null) {
      $projectAccess = new stdClass();
      $projectAccess->can_add_users = false;
      $projectAccess->can_edit = false;
      $projectAccess->can_delete = false;
    }

    return $projectAccess;
  }

}
