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

  protected $appends = array('project_name');

  /**
   * Gets the project name and appends it to the model dynamically
   *
   * @return string
   */
  public function getProjectNameAttribute() {
    $project = Project::where('id', $this->project_id)->first();
    return $project->name;
  }

}
