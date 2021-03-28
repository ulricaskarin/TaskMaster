<?php
/**
 * ★ ContentExceedsCharsCountException Class ★
 *
 * A custom exception message when content exceeds character count.
 * Extends Exception class.
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace exceptions;

class ContentExceedsCharsCountException extends \Exception
{
  public function __construct() {
    parent::__construct();
  }

  /**
   * Custom Exception Message
   * @return string - with the message.
   */
  public function errorMessage() : string {
    return "Sorry! Only 170 characters allowed in your description of the task!";
  }
}
