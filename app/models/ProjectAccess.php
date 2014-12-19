<?php

class ProjectAccess extends Eloquent {

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
  protected $fillable = ['project_id', 'user_id'];

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
  public function getProjectNameAttribute() {
    $project = Project::where('id', $this->project_id)->first();
    return $project->name;
  }

  /**
   * Gets the user email and appends it to the model dynamically
   *
   * @return string
   */
  public function getUserEmailAttribute() {
    $user = User::where('id', $this->user_id)->first();
    return $user->email;
  }

}
