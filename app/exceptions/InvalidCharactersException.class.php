<?php
/**
 * ★ InvalidCharactersException Class ★
 *
 * A custom exception message when input characters are invalid.
 * Extends Exception class.
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace exceptions;

class InvalidCharactersException extends \Exception
{
  public function __construct() {
    parent::__construct();
  }

  /**
   * Custom Exception Message
   * @return string - with the message.
   */
  public function errorMessage() : string {
    return "You have used invalid characters!";
  }
}
