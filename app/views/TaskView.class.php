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
    $this->footer->renderFooter();
    ob_end_flush();
  }


}
