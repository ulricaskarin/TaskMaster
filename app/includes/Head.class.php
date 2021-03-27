<?php
/**
 * ★ Head ★
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

namespace includes;

class Head
{
  private static $lang = 'en';
  private static $charset = 'UTF-8';
  private static $robots = 'index, follow';
  private static $description = 'A Task Master application';
  private static $title = 'Task Master';
  private static $author = 'Ulrica Skarin';
  private static $urlToStylesheet = 'public/css/style.css';

  /**
   * Renders <head> on all pages where included.
   * Starts with Doctype declaration and ends with opening body tag.
   * @return string
   */
  public static function renderHead()
  {
    return
    '<!DOCTYPE html>
    <html lang="'.self::$lang.'" dir="ltr">
    <head>
    <meta charset="'.self::$charset.'">
    <meta name=”robots” content="'.self::$robots.'" />
    <meta name="title" content="'.self::$title.'" />
    <meta name="description" content="'.self::$description.'" />
    <meta name="author" content="'.self::$author.'"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| '.self::$title.' |</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="'.self::$urlToStylesheet.'">
    </head>
    <body>';
  }
}
