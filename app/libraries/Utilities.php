<?php

class Utilities
{

  /**
   * Checks an array for empty fields, can take a nested array (one dim!)
   * Futre: make this a recursive function
   *
   * @param $array array
   *
   * @return bool
   */
  public static function checkEmpty($array)
  {
    $state = true;

    foreach($array as &$item) {
      if(is_array($item)) {
        $state = self::checkEmpty($item);
        if(!$state) break;
      } else {
        if($item === "" || empty($item)) {
          $state = false;
          break;
        }
      }
    }

    return $state;
  }


}