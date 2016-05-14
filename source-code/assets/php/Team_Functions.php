<?php
 
class Team_Functions {
 
    var $team_id;
    var $account_id;

    // constructor
    function __construct($account,$team) {
        $this->account_id = $account;
        $this->team_id = $team;
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         $this->conn->close();
    }
 

    /**
     * Check if user is a team member and return the team info
     */
    public function userIsMember() {

        $query = "SELECT team.id, team.name
                FROM TeamAccount ta, Teams team
                WHERE ta.account_id='".$this->account_id."'
                AND ta.team_id='".$this->team_id."'
                AND ta.team_id=team.id";

        $result = $this->conn->query($query);

        // There must be only one row result
        if ($result->num_rows == 1) {
            // user is a team member
            // return the team details
            return $result->fetch_assoc();
        } else {
            // user is not a team member
            return NULL;
        }

    }

    /**
     * Update team info
     */
    public function updateTeam($name) {
      
      $query = "UPDATE Teams SET name='".$name."' WHERE id='".$this->team_id."'";

      $result = $this->conn->query($query);

      // There must be only one row affected
      if ($this->conn->affected_rows == 1) {
          // team info updated succesfully
          echo "Team Info Updated.";
      } else {
          // team info not updated
          echo "Team Info not updated.";
      }

      // return the new team info
      return $this->userIsMember();

    }

}

?>