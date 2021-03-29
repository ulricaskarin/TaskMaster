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
    $this->taskView->isSortByPriorityLinkClicked()
    ? $this->processTasksByPriority() : $this->processAllTasks();

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

  /**
   * Process Task By Their Priority
   */
  public function processTasksByPriority()
  {
    $priority = null;
    $tasks = array();

    $this->isGetRequest() ? $priority = filter_input(INPUT_GET, 'prio', FILTER_SANITIZE_STRING) : null;
    $tasks = $this->taskModel->sortByPriority((int)$priority);

    if (!is_array($tasks) || !$tasks) {
      $this->taskView->setResponse(MessageView::$nothingReturned);
      $this->redirect();

    } else if(is_array($tasks) && $tasks) {
      $priority === '1' ? $this->taskView->setResponse(MessageView::$priority_1) : '';
      $priority === '2' ? $this->taskView->setResponse(MessageView::$priority_2) : '';
      $this->taskView->renderByPriority($tasks);
    }
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

  public function isGetRequest ()
  {
    return isset($_GET) && ($_SERVER['REQUEST_METHOD'] === 'GET');
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

    if ($this->isGetRequest()) {
            header(BASE_URL, true, 302);
            exit();
    }


  }
}
