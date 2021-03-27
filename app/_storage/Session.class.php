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
    public static $flashMessage = "flashMessage";
    public static $taskAddedSuccess = "taskAddedSucces";

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
}
