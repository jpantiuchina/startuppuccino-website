<?php
 
class StartupProject_Functions {
 
    var $account_id;
    var $project_id;

    // constructor
    function __construct($account) {
        $this->account_id = $account;
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
     * Set the project id
     */
    public function setProject($id) {
      $this->project_id = $id;
    }

    /**
     * Get the info of the specific project
     */
    public function getProjectInfo() {
      
      $query = "SELECT id, title, owner_id, description, avatar, looking_for, is_approved
                FROM "._T_PROJECT." 
                WHERE id='".$this->project_id."';";

      $result = $this->conn->query($query);

      // There must be only one row result
      if ($result->num_rows == 1) {

          return $result->fetch_assoc();
      
      } else {
          // No project found
          return '404';
      }

    }

    /**
     * Check if the account is a memeber of the project
     */
    public function isMyTeam() {

      $query = "SELECT account_id
                FROM "._T_PROJECT_ACCOUNT." 
                WHERE account_id='".$this->account_id."'
                AND project_id='".$this->project_id."';";

      $result = $this->conn->query($query);

      if ($result->num_rows == 1) {

          return true;
      
      }

      return false;

    }

    /**
     * Get the matrix of all projects
     */
    public function getAllProjects() {

      $query = "SELECT i.id,
                       i.title,
                       i.description,
                       i.vision,
                       i.looking_for,
                       i.avatar,
                       i.owner_id,
                       i.is_approved,
                       (SELECT COUNT(*) FROM "._T_IDEA_COMMENT." WHERE project_id = i.id) AS num_of_comments,
                       i.created_at
                FROM "._T_PROJECT." i";

      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        while ($p = $result->fetch_assoc()){
          $projects[] = $p;
        }

        if(count($projects) > 0){
          // Fill with project members
          $projects = $this->loadIdeaMembers($projects);
        }

        return $projects;

      } else {

        return NULL;

      }

    }

    /**
     * Get all idea members
     * TODO THAT IS REDUNDANT! USA CLASS INHERITANCE INSTEAD
     */
    private function loadIdeaMembers($ideas_array){

      foreach ($ideas_array as $i => $idea_value) {

          $query = "SELECT a.id, a.avatar, a.firstName, a.lastName
                    FROM "._T_IDEA_ACCOUNT." AS ia 
                    JOIN "._T_ACCOUNT." AS a 
                    ON ia.account_id = a.id
                    WHERE ia.project_id = ".$ideas_array[$i]['id'].";";

          $result = $this->conn->query($query);

          $members = [];

          if($result){

              while ($member = $result->fetch_assoc()){
                  $members[] = $member;
              }

              if(count($members) > 0){
                  $ideas_array[$i]['members'] = $members;
              }

          }

      }

      return $ideas_array;

    }

}

?>