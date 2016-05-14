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
     * Get the info of the specific team
     */
    public function getTeamInfo() {
      
      $query = "SELECT * FROM Teams
                WHERE id='".$this->team_id."';";

      $result = $this->conn->query($query);

      // There must be only one row result
      if ($result->num_rows == 1) {
          
          // Store result into team_data array
          $team_data = [];
          $team_data = $result->fetch_assoc();
          
          // Add to team_data array the list of team_members
          $team_data['members'] = [];

          $query = "SELECT a.firstName, a.lastName, a.background, a.id 
                      FROM TeamAccount ta, Account a, Teams t
                      WHERE ta.team_id = '". $this->team_id ."'
                      AND t.id = ta.team_id
                      AND ta.account_id = a.id";
  
          $result = $this->conn->query($query);

          // Add each team member to the team_data array
          if($result->num_rows > 0){

            while ($member = $result->fetch_assoc()) {
              
              $team_data['members'][] = $member;

            }

          }

          // return the team details
          return $team_data;
      
      } else {
          // No team found
          return NULL;
      }

    }

    /**
     * Get Team Project
     */
    public function getTeamProject() {
        
      $query = "SELECT * FROM Project WHERE team_id = '" . $this->team_id ."';";

      $result = $this->conn->query($query);

      // There must be only one row result (only one project each team)
      if ($result->num_rows == 1) {
          // return the project
          return $result->fetch_assoc();
      } else {
          // project not found
          return NULL;
      }

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
      return $this->getTeamInfo();

    }

}

?>