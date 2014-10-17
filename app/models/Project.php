<?php

class Project extends Eloquent {

  use SoftDeletingTrait;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'projects';


}
