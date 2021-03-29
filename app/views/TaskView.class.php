<?php
/**
 * ★ Task View ★
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

//TODO remember: redirect user on add task

namespace views;

use \_storage\Session;

class TaskView
{
  private $head;
  private $footer;
  private static $heading = 'Task Master';
  private static $addButton = 'ADD TASK?';
  private static $hideButton = 'HIDE';
  private static $title = 'TaskView::Title';
  private static $content = 'TaskView::Content';
  private static $highPrio = 'TaskView::HighPriority';
  private static $lowPrio = 'TaskView::LowPriority';
  private static $submitTask = 'TaskView::SubmitTask';
  private static $messageId = 'TaskView::Message';
  public $allTasks ='';


  public function __construct()
  {
    $this->head = new \includes\Head();
    $this->footer = new \includes\Footer();
  }

  /**
   * Renders ADD button
   * When clicked -> serves user with "add task form".
   * @return string
   */
  public function renderAddButton() : string
  {
    return
    '<div class="row">
    <div class="col-md-6 mx-auto">
    <a class="button add" role="button"
    href=?add title="'.self::$addButton.'">'.self::$addButton.'&nbsp;<i class="fas fa-arrow-down"></i></a>
    </div>
    ';
  }

  /**
   * Renders HIDE button
   * When clicked -> hides "add task form" from user.
   * @return string
   */
  public function renderHideButton() : string
  {
    return '<a class="button" role="button"
    href=?hide title="'.self::$hideButton.'">'.self::$hideButton.'&nbsp;<i class="fas fa-arrow-up"></i></a>';
  }

  /**
   * Is Add Button clicked?
   * Listens to user action on add button.
   * @return bool - true when clicked
   */
  public function isAddButtonClicked() : bool
  {
    return isset($_GET['add']) ? true : false;
  }

  /**
   * Is Hide Button clicked?
   * Listens to user action on hide button.
   * @return bool - true when clicked
   */
  public function isHideButtonClicked() : bool
  {
    return isset($_GET['hide']) ? true : false;
  }

  /**
   * Is Sort By Priority Links clicked?
   * When user asks for sorting of tasks by priority.
   * @return bool - true if clicked
   */
  public function isSortByPriorityLinkClicked() : bool
  {
    return isset($_GET['prio']) ? true : false;
  }

  /**
   * Get Title of Task from user input in form.
   * @return string - the title of the task.
   */
  public function getTitle() : string
  {
    return isset($_POST[self::$title])&& !empty($_POST[self::$title]) ? trim($_POST[self::$title]) : '';
  }

  /**
   * Get Content of Task from user input in form.
   * @return string - the content of the task.
   */
  public function getContent() : string
  {
    return isset($_POST[self::$content]) && !empty($_POST[self::$content]) ? trim($_POST[self::$content]) : '';
  }

  /**
   * Get Priority (high=1 or low=2) of Task from user input in form.
   * @return int - 2 is default if no priority chosen.
   */
  public function getPriority() : int
  {
    if (isset($_POST[self::$highPrio])) {

      return $_POST[self::$highPrio];

    } elseif (isset($_POST[self::$lowPrio])) {

      return $_POST[self::$lowPrio];

    } else {

      return 2;
    }
  }

  /**
   * User tries to submit / add new task to [task] table.
   *
   * @return bool - true if pushing submit on add task.
   */
  public function userTrySubmitTask() : bool
  {
    return isset($_POST[self::$submitTask]) ? true : false;
  }

  /**
   * Resets $_POST
   */
  public function resetForm()
  {
    return $_POST = [];
  }

  /**
   * Set Response
   * Message set within a request session variable.
   *
   * @param string $message Message to user.
   *
   */
  public function setResponse(string $message)
  {
    if (is_string($message)) {
      Session::set(Session::$flashMessage, $message);
    }
  }

  /**
   * Get Response
   * If message sent with session, serves this message to user.
   *
   * @return string $message - Message to user.
   */
  public function getResponse() : string
  {
    if (Session::get(Session::$flashMessage)) {
      $messageToUser = $_SESSION[Session::$flashMessage];
      Session::destroyOne(Session::$flashMessage);
      return $messageToUser;
    }
    return '';
  }

  /**
   * Serves the correct view to the user based on user action.
   * If 'Add Button' is clicked -> shows 'Add Task Form'
   * If not --> shows all Tasks and 'Add button'.
   *
   * @return string
   */
  public function responseView() : string
  {

    $output = null;
    $messageToUser = $this->getResponse();
    var_dump($messageToUser);

    $this->isAddButtonClicked() && !Session::get(Session::$addTaskSuccess) ? $output = $this->renderAddForm($messageToUser)
    : $output = $this->hideAddForm($messageToUser);

    Session::destroyAll();

    return $output;
  }

  /**
   * Render All Tasks
   * @param  array  - array of tasks from [tasks] table.
   * @return string - html
   */
  public function renderAllTasks(array $tasks = [])
  {
    ob_start();

    echo '<div class="space"></div><div class="row">';

    foreach($tasks as $array =>$value) {
        echo'
        <div class="col-md-4">
        <div class="task_card" >
        <div class="card-body">
        <h5 class="task_card_title">'.$value["title"].'</h5>
        <h6 class="task_card_prio_'.$value["priority"].'"></h6>
        <p class="task_card_text">'.$value["content"].'</p>
        <a href="#" class="card-link">Edit</a>
        <a href="#" class="card-link">Delete</a>
        </div>
        </div>
        </div>';
      }

      echo '</div></div>';

      $this->allTasks = ob_get_clean();
      return $this->allTasks;
  }

  /**
   * Render Tasks by their priority
   * @param  array  $tasks - array of tasks from [tasks] table.
   * @return string - HTML
   */
  public function renderByPriority(array $tasks = [])
  {
    ob_start();

    echo '<div class="space"></div><div class="row">';

    foreach($tasks as $array =>$value) {
        echo'
        <div class="col-md-4">
        <div class="task_card" >
        <div class="card-body">
        <h5 class="task_card_title">'.$value["title"].'</h5>
        <h6 class="task_card_prio_'.$value["priority"].'"></h6>
        <p class="task_card_text">'.$value["content"].'</p>
        <a href="#" class="card-link">Edit</a>
        <a href="#" class="card-link">Delete</a>
        </div>
        </div>
        </div>';
      }

      echo '</div></div>';

      $this->allTasks = ob_get_clean();
      return $this->allTasks;
  }

  /**
  * Renders Form for submit / add of new Task.
  * When rendered - a button to hide the form is shown to user.
  * @return string
  */
  public function renderAddForm(string $message) : string
  {
    return

    '
    <div class="row">
    <div class="col-md-6 mx-auto">'

    .self::renderHideButton().

    '</div>
    </div>


    <div class="row">
    <div class="col-md-6 mx-auto">
    <form method="post">
    <fieldset>
    <legend></legend>
    <p class="message error" id="'. self::$messageId .'">'.htmlspecialchars($message).'</p>
    <div class="form-title">My task:</div>

    <label for="'.self::$title.'">Title:</label><br>
    <input type="text" autofocus name="'.self::$title.'" value="'.$this->getTitle().'"><br>

    <label for="'.self::$content.'">Content:</label><br>
    <input type="textarea" name="'.self::$content.'"content" value="'.$this->getContent().'"><br><br>

    <input type="radio" name="'.self::$highPrio.'" value="1">
    <label for="priority">High Priority</label>
    <input type="radio" name="'.self::$lowPrio.'" value="2">
    <label for="priority">Low Priority</label>
    <button type="submit" name="'.self::$submitTask.'" class="btn btn-dark"><i class="fas fa-plus"></i></button>
    <input type="submit" name="'.self::$submitTask.'" value="Submit Task!">
    </fieldset>
    </form>
    </div>
    </div>
    ';
  }

  /**
   * Hides Form for adding of Task.
   * @return string
   */
  public function hideAddForm($message) : string
  {
    return
    self::renderAddButton().
    '<div class="space"></div>

    <div class="col-md-6 mx-auto">
    <p class="message success" id="'. self::$messageId .'">'.htmlspecialchars($message).'</p>
    </div>';
  }

  /**
   * Renders complete page to user.
   * View changes due to user action.
   *
   * @return
   */
  public function renderPage() // TODO Fix footer bug!
  {
    ob_start();
    echo
    $this->head->renderHead().
    '
    <div class="header">
    <h1>'.self::$heading.'</h1>
    <div>
    <a href="index.php">All Tasks</a>
    <a href="?prio=1">High Priority Tasks</a>
    <a href="?prio=2">Low Priority Tasks</a>
    </div>
    </div>
    <div class="subheader"></div>

    <div class="container">'.

    $this->responseView().

    $this->allTasks;
    //$this->footer->renderFooter();
    ob_end_flush();
  }
}
