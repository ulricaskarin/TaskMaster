<?php
/**
 * ★ Task Class ★
 *
 * Extends Model Class.
 *
 * Every call to the database concerning [tasks] table
 * goes through the Task Class.
 *
 * @author: ulricaskarin
 * @version 1.0.0
 */

 namespace models;

 class Task extends \models\Model
 {
   private $error;

   public function __construct()
   {
     parent::__construct();
   }

   public function create (string $title, string $content, int $priority)
   {
     assert(is_string($title) && is_string($content) && is_int($priority));

     if(empty($title)) {
       throw new \exceptions\MissingTitleException();
     } else if(empty($content)) {
       throw new \exceptions\MissingContentException();
       echo 'empty content';
     } else if (empty($priority)) {
        throw new \exceptions\MissingPriorityException();
     } else if ($title !== strip_tags($title) || $content !== strip_tags($content)){
        throw new \exceptions\InvalidCharactersException();
     }

     // Insert data in table [tasks]
     $query = 'INSERT INTO tasks
              (title, content, priority)
              VALUES
              (:title, :content, :priority)';

     $this->db->query($query);

     $this->db->bind(':title', $title);
     $this->db->bind(':content', $content);
     $this->db->bind(':priority', $priority);

     $result = $this->db->execute();

     return $result;
   }
 }
