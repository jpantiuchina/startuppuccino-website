<?php
 
class People_Functions {
 
    var $account_id;
    var $person_id;

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
     * Set the account id of the selected profile
     */
    public function setPerson($person) {
      $this->person_id = $person;
    }

    /**
     * Get the info of the specific account
     */
    public function getPersonInfo() {
      
      $query = "SELECT about, avatar, background, skills, socials, email, firstname, lastname, role
                FROM "._T_ACCOUNT." WHERE id='".$this->person_id."';";

      $result = $this->conn->query($query);

      // There must be only one row result
      if ($result->num_rows == 1) {

          return $result->fetch_assoc();
      
      } else {
          // No team found
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

      $query = "SELECT id, firstname, lastname, avatar, background, role FROM "._T_ACCOUNT.";";

      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        // Store all teams in an array
        while ($person = $result->fetch_assoc()){
          $people[] = $person;
        }

        // Return all people info
        return $people;

      } else {

        // No people found
        return NULL;

      }

    }

}

?>