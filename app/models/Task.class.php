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

  /**
  * Create Task
  * @param  string $title    - title of Task
  * @param  string $content  - content of Task
  * @param  int    $priority - priority of Task
  * @return bool   True if successful
  */
  public function create (string $title, string $content, int $priority)
  {
   assert(is_string($title) && is_string($content) && is_int($priority));
   //TODO Max 14 chars in title. Max 100 in content?
   if(empty($title)) {
     throw new \exceptions\MissingTitleException();
   } else if (strlen($title) >15) {
     throw new \exceptions\TitleExceedsCharsCountException();
   } else if(empty($content)) {
     throw new \exceptions\MissingContentException();
   } else if (strlen($content) > 170){
     throw new \exceptions\ContentExceedsCharsCountException();
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

  public function edit($post, $id)
  {
   $query = 'UPDATE tasks
            SET title = :title, content = :content, priority = :priority
            WHERE id = :id';

   $this->db->query($query);
   $this->db->bind(':title', $post['title']);
   $this->db->bind(':content', $post['content']);
   $this->db->bind(':priority', $post['priority']);
   $this->db->bind(':id', $id);
   $this->db->execute();

   foreach ($post as $key => $value) {

      if ($value !== '') {
        $query = "UPDATE tasks
        SET title = :title, content = :content, priority = :priority
        WHERE id = :id";

        $this->db->query($query);
        $this->db->bind(':title', $post['title']);
        $this->db->bind(':content', $post['content']);
        $this->db->bind(':priority', $post['priority']);
        $this->db->bind(':id', $id);

        $this->db->execute();
      }
   }
   return $this->db->execute();
  }

  /**
  * Get All Tasks
  *
  * @return array associative array with all rows & columns from [task table]
  */
  public function getAllTasks()
  {
   $query = "SELECT * FROM tasks ORDER BY created DESC";

   $this->db->query($query);

   $tasks = $this->db->resultset();

   return $tasks;
  }
}
