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
   * Relationship to the access table
   *
   * @return object
   */
  public function access() {
    return $this->hasMany('ProjectAccess', 'project_id', 'id');
  }

}
