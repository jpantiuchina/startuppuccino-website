<?php
 
class People_Functions {
 
    private $account_id;
    private $person_id;


    private $MENTOR_LIMIT;
    private $mentor_likes;
    private $project_id;
    private $mentor_id;

    // constructor
    function __construct($account) {
        $this->account_id = $account;
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->project_id = $this->getMyProject();
        $this->mentor_likes = $this->loadMentorLikes();
        $this->MENTOR_LIMIT = 3; 
    }
 
    // destructor
    function __destruct() {
         $this->conn->close();
    }
 

    /**
     * Set the account id of the selected profile
     */
    public function setPerson($person) {
      $this->person_id = $person;
    }

    /**
     * Get the info of the specific account
     */
    public function getPersonInfo() {
      
      $query = "SELECT a.about, a.avatar, a.background, a.skills, a.id,
                       a.socials, a.email, a.firstname, a.lastname, a.role,
                       p.id as project_id, p.avatar as project_avatar, p.title as project_title
                FROM "._T_ACCOUNT." AS a
                LEFT JOIN "._T_PROJECT_ACCOUNT." AS pa
                ON pa.account_id = a.id
                LEFT JOIN "._T_PROJECT." AS p 
                ON pa.project_id = p.id 
                WHERE a.id='".$this->person_id."';";

      $result = $this->conn->query($query);

      // There must be only one row result
      if ($result->num_rows == 1) {

          return $result->fetch_assoc();
      
      } else {
          // No personal information found
          return NULL;
      }

    }

    /**
     * Check if the person is the logged user
     */
    public function isMyProfile() {
      return $this->account_id == $this->person_id;
    }

    /**
     * Get the list of all people
     */
    public function getAllPeople() {

      $query = "SELECT a.id, a.firstname, a.lastname, a.avatar, a.background, a.role,
                       (SELECT IF (COUNT(*)>0, 'unlike', 'like') vote
                        FROM "._T_PROJECT_MENTOR." WHERE account_id=a.id AND project_id='".$this->project_id."') AS vote_label 
                FROM "._T_ACCOUNT." a;";

      $result = $this->conn->query($query);

      if($result && $result->num_rows > 0){

        // Store all teams in an array
        while ($person = $result->fetch_assoc()){
          $people[] = $person;
        }

        // Return all people info
        return $people;

      } else {

        // No people found
        return [];

      }

    }


    /**
     * Get a list of residence mentors
     */
    public function getResidenceMentors() {
      
      $query = "SELECT mentor_id
                FROM "._T_RESIDENCE_MENTORS.";";

      $result = $this->conn->query($query);

      $mentor_ids = [];

      if ($result) {

          while ($mentor = $result->fetch_assoc()){
            $mentor_ids[] = $mentor['mentor_id'];
          }

      }

      return $mentor_ids;

    }












    public function setMentorId($id) {
      $this->mentor_id = $id;
    }

    public function getMyProject() {

      $query = "SELECT l.project_id FROM "._T_PROJECT_ACCOUNT." AS l 
                WHERE l.account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      if($result && $result->num_rows == 1) {
        
        return $result->fetch_assoc()['project_id'];

      }
     
      return null;

    }

    /**
     * Like the current idea
     */
    public function likeMentor() {
      
      if(count($this->mentor_likes) >= $this->MENTOR_LIMIT){
        return "You have reached the maximum number of mentors you can select.";
      }

      $query = "INSERT INTO "._T_PROJECT_MENTOR." (project_id, account_id) 
                VALUES ('".$this->project_id."', '".$this->mentor_id."');";

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
      
      $query = "DELETE FROM "._T_PROJECT_MENTOR." 
                WHERE account_id='".$this->mentor_id."' AND project_id='".$this->project_id."';";

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

      $query = "SELECT l.account_id FROM "._T_PROJECT_MENTOR." AS l 
                WHERE l.project_id='".$this->project_id."';";

      $result = $this->conn->query($query);

      $temp_arr = [];

      if($result && $result->num_rows > 0) {
        while($idealike = $result->fetch_assoc()) {
          $temp_arr[] = $idealike['account_id'];
        }
      }
     
      return $temp_arr;

    }




    /**
     * Only for educators
     */
    public function getProjectMentorChoices(){
      
      $query = "SELECT p.title, a.firstName, a.lastName 
                FROM "._T_PROJECT." AS p
                JOIN "._T_PROJECT_MENTOR." AS mp
                ON mp.project_id=p.id
                JOIN "._T_ACCOUNT." a
                ON mp.account_id=a.id
                ORDER BY `p`.`title` ASC";
      
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