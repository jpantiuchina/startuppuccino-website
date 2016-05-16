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

      }
      
      // No people found
      return NULL;

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

      }
      
      // No ideas found
      return NULL;

    }

    /**
     * Update Idea Details
     */
    public function updateIdea(/* ... */) {
      
      // Should be better here to doublecheck if some parameters is empty (not required now)

      // ...

    }

    /**
     * Join Idea
     */
    public function joinIdea() {
      
      $query = "INSERT INTO IdeaAccount (idea_id,account_id,date) VALUE ('".$this->idea_id."','".$this->account_id."',NOW());";
      $query .= "UPDATE Ideas SET current_team_size = current_team_size + 1 WHERE id=".$this->idea_id.";";

      if($this->conn->multi_query($query)){

        // Count the number of affected rows
        $i = 0;
        do {
            $i += $this->conn->affected_rows;
        } while($this->conn->next_result());
        
        if($i == 2) return "ok";
        else return "Error, not all the query have been executed $i";

      }
      
      return "Error";

    }

    /**
     * Leave Idea
     */
    public function leaveIdea() {
      
      // The idea owner cannot leave the idea
      if($this->account_id == $this->ideaOwnerID()) {
        return "You are the owner! You cannot leave the idea.";
      }

      $query = "DELETE FROM IdeaAccount WHERE idea_id='".$this->idea_id."' AND account_id='".$this->account_id."';";
      $query .= "UPDATE Ideas SET current_team_size = current_team_size - 1 WHERE id=".$this->idea_id.";";

      if($this->conn->multi_query($query)){

        // Count the number of affected rows
        $i = 0;
        do {
            $i += $this->conn->affected_rows;
        } while($this->conn->next_result());
        
        if($i == 2) return "ok";
        else return "Error, not all the query have been executed $i";

      }

      return "Error";

    }

    /**
     * Get the selected idea owner
     */
    private function ideaOwnerID() {
      
      $query = "SELECT owner_id FROM Ideas WHERE id='".$this->idea_id."';";
        
      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        return $result->fetch_assoc()['owner_id'];

      }

      return NULL;

    }

    /**
     * Get team size
     */
    public function getTeamsize() {
      
      $query = "SELECT id FROM IdeaAccount WHERE idea_id='".$_POST['idea_id']."'";

      $result = $this->conn->query($query);

      if($result->num_rows > 0) {

        return $result->num_rows;

      } else {

        return "Error, nothing found";

      }

    }

    /**
     * Create a new Idea
     */
    public function newIdea($title,$team_size,$description,$background_pref) {

      // Clean inputs
      $title = trim($title);
      $team_size = intval($team_size);
      $description = trim($description);

      // Validate inputs
      if($title != "") {

        if($description != "") {

          if(strlen($description) < 141){
            
            if($team_size > 1) {

              $query = "INSERT INTO Ideas (title,owner_id,team_size,description,date,background_pref)
                        VALUES ('".$title."','".$this->account_id."','".$team_size."','".$description."',NOW(),'".$background_pref."');";

              $result = $this->conn->query($query);

              if($this->conn->affected_rows == 1) return "ok";

              return "Error, please try again.";

            } else {

              return "Team size cannot be less than 2.";

            }

          } else {

            return "Description cannot exced 140 characters.";

          }

        } else {
          
          return "Description is empty.";

        }

      } else {

        return "Title is empty.";

      }
      
    }

    /**
     * Delete Idea
     */
    public function deleteIdea() {
      
      // Check idea ownership
      if($this->account_id != $this->ideaOwnerID()) {
        return "You are not the owner!";
      }

      // Delete the idea
      $query = "DELETE FROM Ideas WHERE id='".$this->idea_id."' AND owner_id='".$this->account_id."';";
      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1){

        $team_size = $this->getTeamsize();

        $query = "DELETE FROM IdeaAccount WHERE idea_id='".$this->idea_id."';";
        $result = $this->conn->query($query);

        if($this->conn->affected_rows == $team_size){

          return "ok";

        }

        $team_size_deleted = $this->conn->affected_rows;
        return "Idea not correctly deleted. Only $team_size_deleted/$team_size members deleted.";

      }

      return "It was not possible to delete the idea, please try later.";

    }

}

?>