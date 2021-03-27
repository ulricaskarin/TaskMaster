<?php
/**
 * Index - Start of the application.
 *
 * PHP Version 8.0.2
 * @author: ulricaskarin
 * @version 1.0.0
 */

require_once('_env.php');
require_once(ROOT_PATH .'/app/_config/_autoload.php');
use \_storage\Session;

Session::startSession();
Session::displaySessionArray();

try {
  $masterControl = new controllers\MasterController();
  $masterControl->start();

} catch (\Exception $e) {
  echo $e->errorMessage();
}
