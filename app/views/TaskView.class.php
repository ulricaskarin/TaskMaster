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
  public function __construct()
  {

  }

  public function renderHTML()
  {
    ob_start();
    echo
    '<!DOCTYPE html>
    <html>
    <body>

    <h2>Test Task Form</h2>

    <form action="post">
      <label for="title">Title:</label><br>
      <input type="text" name="title" value=""><br>
      <label for="content">Content:</label><br>
      <input type="text" name="content" value=""><br><br>
      <input type="radio" name="highpriority" value="1" name="prio">
      <label for="priority">High Priority</label>
      <input type="radio" name="lowpriority" value="2" name="prio">
      <label for="priority">Low Priority</label>
      <input type="submit" value="Submit">
    </form>

    </body>
    </html>
    ';
    ob_end_flush();
  }
}
