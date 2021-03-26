<?php
/**
 * ★ MissingTitleException Class ★
 *
 * A custom exception message when title is missing.
 * Extends Exception class.
 *
 *
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace exceptions;

class MissingTitleException extends \Exception
{
  public function __construct() {
    parent::__construct();
  }

  /**
   * Custom Exception Message
   * @return string - with the message.
   */
  public function errorMessage() : string {
    return "You need to fill in your title!";
  }
}
