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

use \_storage\Session;
use \views\MessageView;

class TaskController
{
  private $taskModel;
  private $taskView;
  public $allTasks;

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

    $this->processTasksByPriority(1);
    $this->processAllTasks();
    $this->taskView->renderPage();
  }

  /**
   * Process user submitted task.
   * Gets input from Task view and serves them to the Task model
   * for further creation of task.
   *
   */
  public function processSubmit()
  {
    $title = $this->taskView->getTitle();
    $content = $this->taskView->getContent();
    $priority = $this->taskView->getPriority();

    $this->taskModel->create($title, $content, $priority) ? $this->addTaskSuccess() : '';
  }

  /**
   * Process all tasks.
   * Asks TaskModel for all tasks in database table [tasks] and instructs
   * TaskView to render them.
   */
  public function processAllTasks()
  {
    $this->allTasks = $this->taskModel->getAllTasks();
    $this->taskView->renderAllTasks($this->allTasks);
  }

  public function processTasksByPriority(int $prio)
  {
    $prio = 2;
    $tasks = $this->taskModel->sortByPriority(2);
    $this->taskView->renderTasksByPriority($tasks);
  }

  /**
   * Add task Success.
   * On successful add of task ->
   * -> instructs TaskView to reset form.
   * -> sets Success Session.
   * -> redirects user.
   */
  public function addTaskSuccess()
  {
    $this->taskView->resetForm();

    Session::set(Session::$addTaskSuccess, 'Success');
    $this->taskView->setResponse(MessageView::$addTaskSuccess);

    $this->redirect();

  }

  /**
   * Checks if POST request
   * @return boolean - true if post
   */
  public function isPostRequest ()
  {
    return isset($_POST) && ($_SERVER['REQUEST_METHOD'] === 'POST');
  }

  /**
   * Redirects user to index page if post request.
   * Hinders from double posting on refresh page.
   */
  public function redirect ()
  {
    if ($this->isPostRequest()) {
            header(BASE_URL, true, 302);
            exit();
    }
  }
}
