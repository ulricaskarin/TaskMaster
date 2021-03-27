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
  private static $hideFormButton = 'HIDE FORM';

  public function __construct()
  {
    $this->head = new \includes\Head();
    $this->footer = new \includes\Footer();
  }

  public function renderHTML()
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
