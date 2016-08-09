<?php
 
class Educators_Functions {
 
    var $account_id;
    var $ideas_func;

    function __construct($account) {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        // Set the account_id
        $this->account_id = $account;
        // Initialize the ideas functions object
        require_once 'Ideas_Functions.php';
        $this->ideas_func = new Ideas_Functions($this->account_id);
    }
 
    function __destruct() {
        $this->conn->close();
    }
 
    /**
     * Approve the selected idea
     */
    public function approveIdea($idea_id) {

      $query = "UPDATE Ideas SET approved='T' WHERE id='".$idea_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        return "Idea approved";
      }

      return "Something went wrong";

    }

    /**
     * Disapprove the selected idea
     */
    public function disapproveIdea($idea_id) {

      $query = "UPDATE Ideas SET approved='F' WHERE id='".$idea_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        return "Idea disapproved";
      }

      return "Something went wrong";

    }

    /**
     * Create a new team/project based on the selected idea
     */
    public function upgradeIdea($idea_id) {

      // Set the idea
      $this->ideas_func->setIdea($idea_id);

      // Get data of the idea
      if($idea_data = $this->ideas_func->getIdeaData()){
        
        // Get idea members
        if($idea_members = $this->ideas_func->getIdeaMembers()){
          
          // Save the number of members (without counting the idea owner)
          $num_idea_members = count($idea_members)-1;

          // Add new Team
          // When the team is created it will have the same name of the idea title
          $query = "INSERT INTO Teams (name) VALUES ('".$idea_data['title']."');";
            
          $result = $this->conn->query($query);

          if($this->conn->affected_rows == 1) {

            $team_id = $this->conn->insert_id;
            
            // Add new team members
            $members_not_added = [];
            foreach ($idea_members as $member_id) {
              
              $this->conn->query("INSERT INTO TeamAccount (team_id,date,account_id) VALUES ('".$team_id."',NOW(),'".$member_id."')");

              if($this->conn->affected_rows != 1) $members_not_added[] = $member_id;

            }

            if(count($members_not_added)==0) {

              // Create the project associated with the team
              $query = "INSERT INTO Project (description,title,team_id,created_date,updated_date) VALUES ('".$idea_data['description']."','".$idea_data['title']."','".$team_id."',NOW(),NOW())";
              
              $this->conn->query($query);

              if($this->conn->affected_rows == 1) {

                // Delete the idea tuples from Ideas
                $this->conn->query("DELETE FROM Ideas WHERE id='".$idea_id."';");

                if($this->conn->affected_rows == 1) {

                  // Delete old idea members from IdeaAccount
                  $this->conn->query("DELETE FROM IdeaAccount WHERE idea_id='".$idea_id."';");

                  if($this->conn->affected_rows == $num_idea_members) {
                    return "Idea has been converted into the new team '".$idea_data['title']."'";
                  }

                  return "Not all the idea members have been deleted";

                } else {

                  return "The new team has been created but it was not possible to delete the idea.";

                }

              } else {

                return "I'm sorry, I could not create the new project.";

              }

            } else {

              return "I'm sorry, finally I could not store ".count($members_not_added)." team members";

            }

          } else {

            return "I'm sorry, I was not able to create a new team.";

          }

        } else {

           return "I'm sorry, I was not able to get the idea members.";

        }

      }

      // No data found
      return "Idea data not found.";

    }

}

?>