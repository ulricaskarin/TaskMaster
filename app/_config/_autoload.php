<?php
/**
 * ★ Autoload ★
 *
 * Using spl_autoload_register allows registering
 * multiple functions / methods. All put in a queue and
 * sequentially called when a new Class is declared within
 * the application.
 *
 * @param string $class
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */
spl_autoload_register(function (string $class)
{
  include 'app/' . str_replace('\\', '/', $class) . '.class.php';
});
