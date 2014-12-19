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

}
