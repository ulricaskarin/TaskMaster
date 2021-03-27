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
  private static $highPrio = 'TaskView::HighPriority';
  private static $lowPrio = 'TaskView::HighPriority';
  private static $messageId = 'TaskView::Message';


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
    return isset($_GET["hide"]) ? true : false;
  }

  public function getResponse() : string
  {
    if (Session::get(Session::$flashMessage)) {
      $messageToUser = $_SESSION[Session::$flashMessage];
      Session::destroyOne(Session::$flashMessage);
      return $messageToUser;
    }
    return 'This is just a test';
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

    $this->isAddButtonClicked() ? $output = $this->renderAddForm($messageToUser)
    : $output = $this->hideAddForm();

    return $output;
  }

  /**
  * Renders Form for adding of Task.
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
    <form action="post">
    <fieldset>
    <legend></legend>
    <p class="message" id="'. self::$messageId .'">'.htmlspecialchars($message).'</p>
    <div class="form-title">My task:</div>
    <label for="title">Title:</label><br>
    <input type="text" autofocus name="title" value=""><br>
    <label for="content">Content:</label><br>
    <input type="textarea" name="content" value=""><br><br>
    <input type="radio" name="'.self::$highPrio.'" value="1">
    <label for="highpriority">High Priority</label>
    <input type="radio" name="'.self::$lowPrio.'" value="2">
    <label for="lowpriority">Low Priority</label>
    <input type="submit" value="Add me!">
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
  public function hideAddForm() : string
  {
    return
    self::renderAddButton();
  }

  //TODO Add method to list all tasks dynamically!

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
    <div class="header"><h1>'.self::$heading.'</h1></div>
    <div class="subheader"></div>

    <div class="container">'.

    $this->responseView().
    '
    <div class="space"></div>
    <div class="row">

    <div class="col-md-4">
    <div class="task_card" >
    <div class="card-body">
    <h5 class="task_card_title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
    </div>
    </div>
    </div>

    <div class="col-md-4">
    <div class="task_card" >
    <div class="card-body">
    <h5 class="task_card_title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
    </div>
    </div>
    </div>

    <div class="col-md-4">
    <div class="task_card" >
    <div class="card-body">
    <h5 class="task_card_title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
    </div>
    </div>
    </div>


    </div>
    </div>'.
    $this->footer->renderFooter();
    ob_end_flush();
  }
}
