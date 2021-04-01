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
use \helpers\PageController as Pager;

class TaskController
{
  private $taskModel;
  private $taskView;
  private $pageControl;
  private $allTasks;
  private $totalTasks;
  private static $numberOfResultsPerPage = 9;


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
   *
   * Asks TaskModel for all tasks in database table [tasks] and instructs
   * and sends results to paginateTask method.
   */
  public function processAllTasks()
  {
    $this->allTasks = $this->taskModel->getAllTasks();
    $this->totalTasks = $this->taskModel->getRows();

    if (is_array($this->allTasks) || !empty($this->allTasks)) {
      $this->paginateTask($this->allTasks,
                                    self::$numberOfResultsPerPage,
                                    $this->totalTasks);
    }
  }

  /**
   * Process Task By Their Priority
   */
  public function processTasksByPriority() //TODO Fix pagination here
  {
    $priority = null;

    $this->isGetRequest() ? $priority = filter_input(INPUT_GET, 'prio', FILTER_SANITIZE_STRING) : null;

    $this->allTasks = $this->taskModel->sortByPriority((int)$priority);
    $this->totalTasks = $this->taskModel->getRows();

    if(is_array($this->allTasks) && !empty($this->allTasks)) {
      $priority === '1' ? $this->taskView->setResponse(MessageView::$priority_1) : '';
      $priority === '2' ? $this->taskView->setResponse(MessageView::$priority_2) : '';

      $this->paginateTask($this->allTasks,
                          self::$numberOfResultsPerPage,
                          $this->totalTasks);
    } else {
      $this->taskView->setResponse(MessageView::$nothingReturned); //TODO keep?
      //$this->redirect();
    }
  }

  /**
   * Paginates Tasks
   * Creates a new PageHelper in order to paginate results
   *
   * @param  array $resultSet    - array with all queried tasks
   * @param  int $countPerPage   - number of results to be displayed per page
   * @param  int $totalRows      - total rows returned from taskModel
   */
  public function paginateTask(array $resultSet, int $countPerPage, int $totalRows)
  {
    $pager = new \helpers\PageHelper($resultSet, $countPerPage, $totalRows);

    $totalRows = $totalRows;

    $result = $pager->setResults();

    $pages = [$pager->getFirstPage(),
              $pager->getPreviousPage(),
              $pager->paginate(),
              $pager->getNextPage(),
              $pager->getLastPage()];

    $this->sendTasksToView($result, $pages, $totalRows);
  }

  /**
   * Sends tasks to view
   *
   * @param  array $result     - array of results
   * @param  array $pages     - string with page links
   * @param  string $totalRows - total number of rows
   */
  public function sendTasksToView(array $result, array $pages, int $totalRows)
  {
    for ($i = 0; $i < $totalRows; $i++) {
      $this->taskView->renderAllTasks($result, $pages);
    }
  }

  /**
   * Add task Success.
   *
   * On successful add of task ->
   * -> instructs TaskView to reset form.
   * -> redirects user.
   */
  public function addTaskSuccess()
  {
    $this->taskView->resetForm();
    $this->redirect();
  }

  /**
   * Checks if POST request
   *
   * @return boolean - true if post request
   */
  public function isPostRequest ()
  {
    return isset($_POST) && ($_SERVER['REQUEST_METHOD'] === 'POST');
  }

  /**
   * Checks if GET request
   *
   * @return boolean - true if get request
   */
  public function isGetRequest () // TODO move this to RouterHelper.class?
  {
    return isset($_GET) && ($_SERVER['REQUEST_METHOD'] === 'GET');
  }

  /**
   * Redirects user to index page if post request.
   * Hinders from double posting on refresh page.
   */
  public function redirect () // TODO move this to RouterHelper.class?
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
