<?php

class Project extends Eloquent
{

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
   * Appendable items to the object on retrieval
   *
   * @var array
   */
  protected $appends = ['is_owner'];

  /**
   * Relationship to the access table
   *
   * @return object
   */
  public function access() 
  {
    return $this->hasMany('ProjectAccess', 'project_id', 'id');
  }

  /**
   * Checks if user is owner of project and appends it to the model dynamically
   *
   * @return boolean
   */
  public function getIsOwnerAttribute()
  {
    $user = Sentry::getUser();
    return !$user->hasAnyAccess(['manage']) && $user->id !== $this->user_id ? false : true;
  }

}
