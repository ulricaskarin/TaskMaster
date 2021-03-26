<?php
/**
 * ★ Database Class ★
 *
 * Connects to database and simplifies PDO functions.
 *
 * The Database will be initialized with the credentials
 * of the SQL database, and will create a new PDO instance.
 *
 * The credentials are stored in db_config.php for example:
 * define('DB_HOST', 'localhost');
 * define('DB_USER', 'user');
 * define('DB_PASS', 'myPass');
 * define('DB_NAME', 'myDatabase');
 *
 * The rest of the model classes will access it by extending the
 * Model class, as $this->db.
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

 namespace models;

 // ★ Requires credentials:
 require_once(ROOT_PATH.'/app/_config/db_config.php');

 use PDO;

 class Database
 {
   /**
    * Private properties for database access
    * using secretly defined constants
    */
     private $host = DB_HOST;
     private $user = DB_USER;
     private $pass = DB_PASS;
     private $dbname = DB_NAME;

     /**
      * Handler -> the PDO instance.
      * Representing the connection to the database.
      * @var PDO
      */
     private $handler;

     private $error;

     private $statement;

     /**
      * Initialize PDO connection. Set the handler as
      * the new instance to be used throughout each additional
      * methods.
      *
      * @throws PDOException - if failing to create PDO object.
      */
     public function __construct()
     {
       $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      $options = [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
      ];

      try {
        $this->handler = new PDO($dsn, $this->user, $this->pass, $options);
      } catch (PDOException $e) {
        $this->error = $e->getMessage();

      }
     }
 }
