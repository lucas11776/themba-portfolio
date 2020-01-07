<?php

namespace Validation;

use Validation\Classes\Tools as Tools;

class Validator extends Tools
{
  /**
   * Slim request object
   * 
   * @var object
   */
  private $request;

  /**
   * Validation rules
   * 
   * @var array
   */
  private $validators;

  /**
   * Validation errors
   * 
   * @var array
   */
  private $error = array();

  /**
   * Validation (value) pair split char
   *  
   * @var string 
   */
  private const SPLIT_STR = '|';

  /**
   * Validation (value) split char
   * 
   * @var string
   */
  private const SPLIT_VAL = ':';

  public function __construct (object $request)
  {
    $this->request = $request;
  }

  public function set_rules (array $validators)
  {
    $this->validators = $validators;
  }

  /**
   * Run validation rules
   * 
   * @return boolean
   */
  public function run()
  {
    $this->clear_error(); // clear errors
    foreach ($this->validators as $key => $value)
    {
      $valid = $this->validate($key, explode(self::SPLIT_STR, $value));
      if ($valid !== true) $this->error[$key] = $valid;
    }
    return count($this->error) === 0 ? true : false;
  }

  /**
   * Validation
   */
  protected function validate (string $key, array $validators)
  {
    // get param name by key
    $val = $this->request->getParams()[$key] ?? '';
    $error = null;

    for ($i = 0; $i < count($validators); $i++)
    {
      // get validator type from string
      $single_validator = explode(self::SPLIT_VAL, $validators[$i]);
      $swich = strtolower($single_validator[0]);

      // validation
      switch ($swich) {

        case 'required':
          if (!$error && $this->required($val)) $error = "The {$key} field is required";
          break;

        case 'min':
          if (!$error && $this->min($val, $single_validator[1])) $error = "The {$key} must have min length " . $single_validator[1] . " .";
          break;

        case 'max':
          if (!$error && $this->max($val, $single_validator[1])) $error = "The {$key} must have max length " . $single_validator[1] . " .";
          break;

        case 'integer':
          if (!$error && $this->integer($val)) $error = "The {$key} field must be type of integer.";
          break;
      }
    }

    return $error === null ? true : $error;
  }

  /**
   * Api response
   * 
   * @param   boolean
   * @param   string
   * @param   array
   * @return  array
   */
  public function response (bool $status = true, string $message = '', array $data = array())
  {
    return array('status' => $status, 'message' => $message, 'data' => $this->error);
  }

  /**
   * Form validation response
   * 
   * @param   string
   * @return  array
   */
  public function validation_response(string $message = '')
  {
    return $this->response((count($this->error) === 0 ? true : false), $message, $this->error);
  }

  /**
   * Get request params
   * 
   * @param  array
   * @return array
   */
  public function values (array $select)
  {
    $array = array();
    for ($i = 0; $i < count($select); $i++) $array[$select[$i]] = $this->request->getParams()[$select[$i]] ?? null;
    return $array;
  }

  /**
   * Validation errors
   * 
   * @param   string
   * @return  array
   */
  public function array_error(string $field = null)
  {
    return $field === null ? $this->error : ($this->error[$field] ?? '');
  }

  /**
   * Clear validation error
   */
  private function clear_error ()
  {
    $this->error = array();
  }
}
