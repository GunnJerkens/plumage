<?php

class BaseController extends Controller
{

  /**
   * Class vars
   *
   * @var $user object
   */
  protected $user, $input;

  /**
   * Class contructor
   */
  function __construct()
  {
    $this->user  = Sentry::getUser();
    $this->input = Input::except('_token');
  }

}
