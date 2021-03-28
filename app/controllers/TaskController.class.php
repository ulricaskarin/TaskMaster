<?php
/**
 * ★ Task Controller ★
 *
 * Serves the view with data from model
 * Serves model with data from view
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace controllers;

class TaskController
{
  private $taskModel;
  private $taskView;

  public function __construct(\models\Task $taskModel,\views\TaskView $taskView)
  {
    $this->taskModel = $taskModel;
    $this->taskView = $taskView;
  }

  /**
   * Listen to user action in TaskView.
   *
   * Asks TaskView to render page, listens and
   * responds to user submit of new task.
   *
   */
  public function listen()
  {
    $this->taskView->renderPage();

    if ($this->taskView->userTrySubmitTask()) {
      $this->processSubmit();
    }
  }

  /**
   * Process user submitted task.
   * Gets input from Task view and serves them to the Task model
   * for further creation of task.
   *
   * On successful creation of task -> asks Task View to reset form.
   */
  public function processSubmit()
  {
    if($this->taskModel->create($this->taskView->getTitle(),
    $this->taskView->getContent(), $this->taskView->getPriority())) {
      // TODO Add reset method.
    }
  }

}
