<?php
 
class StartupProject_Functions {
 
    private $account_id;
    private $project_id;

    private $MENTOR_LIMIT;
    private $mentor_likes;

    // constructor
    function __construct($account) {
        $this->account_id = $account;
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->mentor_likes = $this->loadMentorLikes();
        $this->MENTOR_LIMIT = 3; 
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
     * Only projects have their own page (not ideas)
     */
    public function getProjectInfo() {
      
      $query = "SELECT id, title, owner_id, description, avatar, vision, milestone_2
                FROM "._T_PROJECT." 
                WHERE id='".$this->project_id."'
                AND is_approved=1;";

      $result = $this->conn->query($query);

      // There must be only one row result
      if ($result->num_rows == 1) {

          $project = $result->fetch_assoc();
          $project = $this->loadIdeaMembers([$project])[0];
          return $project;
      
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
                       (SELECT IF (COUNT(project_id)>0, 'unlike', 'like') vote
                        FROM "._T_MENTOR_PROJECT." WHERE account_id='".$this->account_id."' AND project_id=i.id) AS vote_label,
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









    /**
     * Set a new project title
     */
    public function setTitle($value){

      $query = "UPDATE "._T_PROJECT_."
                SET title='".$value."'
                WHERE id='".$this->project_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1){
        return "ok";
      }

      return "Error, please try again.";

    }

    /**
     * Set a new project description
     */
    public function setDescription($value){

      $query = "UPDATE "._T_PROJECT_."
                SET description='".$value."'
                WHERE id='".$this->project_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1){
        return "ok";
      }

      return "Error, please try again.";

    }

    /**
     * Set a new project milestone 2
     */
    public function setMilestone2($value){

      $query = "UPDATE "._T_PROJECT_."
                SET milestone_2='".$value."'
                WHERE id='".$this->project_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1){
        return "ok";
      }

      return "Error, please try again.";

    }













    

    /**
     * Like the current idea
     */
    public function likeMentor() {
      
      if(count($this->mentor_likes) >= $this->MENTOR_LIMIT){
        return "You have reached the maximum number of project you can select.";
      }

      $query = "INSERT INTO "._T_MENTOR_PROJECT." (project_id, account_id) 
                VALUES ('".$this->project_id."', '".$this->account_id."');";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        // Push project_id to user likes
        $this->mentor_likes[] = $this->project_id;
        return "ok";
      }
     
      // Error in the query
      return "Error";
     
    }


    /**
     * Unlike the current idea
     */
    public function unlikeMentor() {
      
      $query = "DELETE FROM "._T_MENTOR_PROJECT." 
                WHERE account_id='".$this->account_id."' AND project_id='".$this->project_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        // Pop project_id to user likes
        $temp_mentor_likes = [];
        foreach ($this->mentor_likes as $project_id) {
          if($project_id != $this->project_id){
            $temp_mentor_likes[] = $project_id;
          }
        }
        $this->mentor_likes = $temp_mentor_likes;
        return "ok";
      }
     
      // Error in the query
      return "Error";
     
    }

    /**
     * Get the list of all ideas IDs that the current user liked
     */
    private function loadMentorLikes(){

      $query = "SELECT l.project_id FROM "._T_MENTOR_PROJECT." AS l 
                WHERE l.account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      $temp_arr = [];

      if($result && $result->num_rows > 0) {
        while($idealike = $result->fetch_assoc()) {
          $temp_arr[] = $idealike['project_id'];
        }
      }
     
      return $temp_arr;

    }




    /**
     * Only for educators
     */
    public function getMentorProjectChoices(){
      
      $query = "SELECT a.firstName, a.lastName, p.title 
                FROM "._T_PROJECT." AS p
                JOIN "._T_MENTOR_PROJECT." AS mp
                ON mp.project_id=p.id
                JOIN "._T_ACCOUNT." a
                ON mp.account_id=a.id
                ORDER BY `a`.`firstName` ASC";
      
      $result = $this->conn->query($query);

      $temp_arr = [];

      if($result && $result->num_rows > 0) {
        while($item = $result->fetch_assoc()) {
          $temp_arr[] = $item;
        }
      }
     
      return $temp_arr;

    }


}

?>