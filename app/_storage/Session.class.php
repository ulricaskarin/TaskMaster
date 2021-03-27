<?php
/**
 * ★ Session ★
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace _storage;

/**
 * Class Session
 * @package _storage
 */
class Session
{
  // Static session variables for different sessions:
  public static $flashMessage = 'flashMessage';
  public static $taskAddedSuccess = 'taskAddedSucces';

  const ZERO = 0;

  /**
   * Starts session.
   */
  public static function startSession()
  {
    if (session_status() === PHP_SESSION_NONE) {
      self::setIniSessionSettings();
      self::setSessionCookieParams();
      session_start();
    }
  }

  /**
   * Sets session configuration in ini.
   * Settings hinder the passing of session id in URL.
   */
  private static function setIniSessionSettings()
  {
    ini_set('session.use_only_cookies', true);
    ini_set('session.use_trans_sid', false);
  }

  /**
   * Sets a session.
   *
   * @param string $key
   * @param string $value
   */
  public static function set(string $key, string $value)
  {
    $_SESSION[$key] = $value;
  }

  /**
   * Gets a session.
   *
   * @param string $key
   * @return bool, true if session is set
   */
  public static function get(string $key) : bool
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return false;
    }
  }
}
