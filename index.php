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
echo 'This is Task Master';

try {
  $task = new models\Task();
  $task->create('Content comes here', 1);
} catch (\Exception $e) {
  echo $e->errorMessage();
}
// $task = new models\Task();
// $task->create( 'Content comes here', 1);
// var_dump($task);
