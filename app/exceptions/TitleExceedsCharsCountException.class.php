<?php
/**
 * ★ TitleExceedsCharsCountException Class ★
 *
 * A custom exception message when title exceeds character count.
 * Extends Exception class.
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace exceptions;

class TitleExceedsCharsCountException extends \Exception
{
  public function __construct() {
    parent::__construct();
  }

  /**
   * Custom Exception Message
   * @return string - with the message.
   */
  public function errorMessage() : string {
    return "Sorry! Only 15 characters allowed in title!";
  }
}
