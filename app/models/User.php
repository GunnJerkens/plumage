<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryModel;

class User extends SentryModel implements UserInterface, RemindableInterface
{

  use UserTrait, RemindableTrait;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('password', 'remember_token');

  /**
   * Appendable items to the object on retrieval
   *
   * @var array
   */
  protected $appends = ['is_admin'];

  /**
   * Relationship to the access table
   *
   */
  public function access()
  {
    return $this->hasMany('ProjectAccess', 'user_id', 'id');
  }

  /**
   * Appends whether an owner is an admin
   *
   * @return bool
   */
  public function getIsAdminAttribute()
  {
    $user = Sentry::getUser();
    return $user->hasAnyAccess(['manage']) ? true : false;
  }

}
