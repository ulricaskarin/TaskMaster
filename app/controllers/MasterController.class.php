<?php
/**
 * ★ Master Controller ★
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace controllers;

class MasterController
{
  private $taskModel;
  private $taskControl;
  private $taskView;

  public function __construct()
  {
    $this->taskModel = new \models\Task();
    $this->taskView = new \views\TaskView();
    $this->taskControl = new \controllers\TaskController($this->taskModel, $this->taskView);
  }

  public function startApplication()
  {
    $this->taskControl->listen();
  }
}
