<?php
 
class Ideas_Functions {
 
    var $account_id;
    var $idea_id;
    var $my_ideas_id;

    // constructor
    function __construct($account) {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->account_id = $account;
        $this->my_ideas_id = $this->readAllMyIdeasIDs();
    }
 
    // destructor
    function __destruct() {
        $this->conn->close();
    }
 
    /**
     * Get the list of all ideas IDs owned by the current user
     */
    private function readAllMyIdeasIDs() {

      $query = "SELECT idea_id FROM IdeaAccount WHERE account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        while ($idea = $result->fetch_assoc()){
          $ideas[] = $idea['idea_id'];
        }

        // Return the array
        return $ideas;

      } else {

        // No people found
        return NULL;

      }

    }

    /**
     * Get the list of all ideas IDs owned by the current user
     */
    public function getAllMyIdeasID() {
      return $this->my_ideas_id;
    }   

    /**
     * Set the idea
     */
    public function setIdea($idea) {
      $this->idea_id = $idea;
    }

    /**
     * Check if the user is the idea owner
     */
    public function isMyIdea() {
      return in_array($this->idea_id, $this->my_ideas_id);
    } 

    /**
     * Get the list of all ideas
     */
    public function getAllIdeas() {

      $query = "SELECT i.title,
                             i.description,
                             i.team_size,
                             i.current_team_size,
                             i.date,
                             i.background_pref,
                             a.firstName, 
                             a.lastName,
                             i.id,
                             i.owner_id
                          FROM Ideas i, Account a WHERE i.owner_id = a.id";

      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        while ($idea = $result->fetch_assoc()){
          $ideas[] = $idea;
        }

        // Return all ideas
        return $ideas;

      } else {

        // No ideas found
        return NULL;

      }

    }

    /**
     * Update Idea Details
     */
    public function updateIdea(/* ... */) {
      
      // Should be better here to doublecheck if some parameters is empty (not required now)

      // ...

    }

}

?>