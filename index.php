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
$task = new models\Task();
$task->create('This is my title', 'Content comes here', 1);
var_dump($task);
