<?php
/**
 * ★ Task View ★
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace views;


class TaskView
{
  private $head;
  private $footer;
  private static $heading = 'Task Master';
  private static $addButton = 'ADD TASK';
  private static $hideButton = 'HIDE FORM';

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
    return '<div class="span2"><a class="btn btn-dark btn-block" role="button"
    href=?add title="'.self::$addButton.'">'.self::$addButton.'</a></div>';
  }

  /**
   * Renders HIDE button
   * When clicked -> hides "add task form" from user.
   * @return string
   */
  public function renderHideButton() : string
  {
    return '<div class="span2"><a class="btn btn-dark btn-block" role="button"
    href=?hide title="'.self::$hideButton.'">'.self::$hideButton.'</a></div>';
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

/**
 * Renders Form for adding of Task.
 * When rendered - a button to hide the form is shown to user.
 * @return string
 */
  public function renderAddForm() : string
  {
    return

    self::renderHideButton().
    '
    <form action="post">
      <label for="title">Title:</label><br>
      <input type="text" name="title" value=""><br>
      <label for="content">Content:</label><br>
      <input type="text" name="content" value=""><br><br>
      <input type="radio" name="highpriority" value="1" name="prio">
      <label for="highpriority">High Priority</label>
      <input type="radio" name="lowpriority" value="2" name="prio">
      <label for="lowpriority">Low Priority</label>
      <input type="submit" value="Submit">
     </form>
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

  /**
   * Serves the correct view to the user based on user action.
   * If 'Add Button' is clicked -> shows 'Add Task Form'
   * If not --> shows all Tasks and 'Add button'.
   * @return string
   */
  public function responseView() : string
  {
    $output='';

    $this->isAddButtonClicked() ? $output = $this->renderAddForm()
    : $output = $this->hideAddForm();

    return $output;
  }

  /**
   * Renders complete page to user
   *
   * @return
   */
  public function renderPage()
  {
    ob_start();
    echo
    $this->head->renderHead().
    '<h1>'.self::$heading.'</h1>
    <h2>Test Task Form</h2>'.
    $this->responseView().
    '<div class="card" style="width: 18rem;">
    <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
    </div>
    </div>'.
    $this->footer->renderFooter();
    ob_end_flush();
  }
}
