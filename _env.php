<?php
/**
 * Define Environment Variables
 */
define("ROOT_PATH", dirname(__FILE__));
define("DEVELOPMENT",true);
define("PRODUCTION", false);
define("BASE_URL","Location:http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
