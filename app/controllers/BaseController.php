<?php

class BaseController extends Controller
{

  /**
   * Class vars
   *
   * @var $user object
   */
  protected $user;

  /**
   * Class contructor
   */
  function __construct()
  {
    $this->user = Sentry::getUser();
  }

}
