<?php

namespace Validation\Classes;

class Tools
{
  /**
   * Check if string is not empty
   * 
   * @param string
   * @return  boolean
   */
  public function required (string $str)
  {
    return empty($str) ? true : false;
  }

  /**
   * Check if value is integer
   * 
   * @param string
   * @return  boolean
   */
  public function integer (string $int)
  {
    return is_numeric($int) ? false : true;
  }

  /**
   * Check if value is string
   * 
   * @param string
   * @return  boolean
   */
  public function string (string $str)
  {
    return is_string($str) ? true : false;
  }

  /**
   * Check if string has required minimun length
   * 
   * @param  string
   * @param   integer
   * @return
   */
  public function min (string $str, int $num)
  {
    return strlen($str) < $num ? true : false;
  }

  /**
   * Check if string has required maximum length
   * 
   * @param  string
   * @param   integer
   * @return
   */
  public function max (string $str, int $num)
  {
    return strlen($str) > $num ? true : false;
  }
}