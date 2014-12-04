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

}
