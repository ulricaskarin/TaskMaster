<?php
/**
 * ★ Model Class ★
 *
 * Creates new instance of the Database Class.
 *
 * An abstract class that creates a new instance of the Database.
 * Allows interaction with the database without creating a new
 * instance in each class.
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

 namespace models;

 abstract class Model
 {
   protected $db;

   public function __construct()
   {
     $this->db = new Database();
   }
 }
