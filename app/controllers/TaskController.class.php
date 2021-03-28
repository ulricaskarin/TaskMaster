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
   */
  public function listen()
  {
    try {
      $this->taskView->userTrySubmitTask() ? $this->processSubmit() : '';
    } catch (\Exception $e) {
			$this->taskView->setResponse($e->errorMessage());
		}
    $this->taskView->renderPage();
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
      $this->taskView->resetForm();
      var_dump($_POST);
    }
  }

}
