<?php

require_once '../app/models/session.php';

class Credential_Functions {
 
    var $email;
    var $password;
    var $fname, $lname, $background, $role, $skills;

    function __construct() {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    function __destruct() {
        $this->conn->close();
    }
 
    /**
     * Evaluate login
     */
    public function login() {

      $query = "SELECT id, avatar, background, email, firstname, lastname, role FROM "._T_ACCOUNT." WHERE email='" . $this->email . "' AND password='" . $this->password . "'";

      $result = $this->conn->query($query);

      // query result is ok if only one match is found (one account)
      if($result && $result->num_rows == 1){

        return $result->fetch_assoc();

      }
      
      // No account found
      // Return an empty array
      return [];

    }

    /**
     * Register new user
     */
    public function register(){

      $query = "INSERT INTO "._T_ACCOUNT." (background, skills, email, firstname, lastname, password, role)
                VALUES ('" . $this->background . "',
                    '" . $this->skills . "',
                    '" . $this->email . "',
                    '" . $this->fname . "',
                    '" . $this->lname . "',
                    '" . $this->password . "',
                    '" . $this->role . "');";
      
      $this->conn->query($query);

      if ($this->conn->affected_rows == 1) {

        return true;

      }

      return false;
    
    }

    /**
     * Check if email already exists
     */
    public function emailExists(){

      $query = "SELECT id FROM "._T_ACCOUNT." WHERE email='" . $this->email . "';";

      $result = $this->conn->query($query);

      if($result && $result->num_rows > 0){

        return true;
      
      }

      return false;

    }

    /**
     * Set the account email
     */
    public function setEmail($email) {
      $this->email = $email;
    }

    /**
     * Set the account password
     */
    public function setPassword($password) {
      $this->password = $password;
    } 

    /**
     * Validate inputs for new account
     */
    public function validateInputs($password,$password2,$email,$fname,$lname,$background,$role,$skills) {

      // Validate required field

      if(empty($password)) {
        
        return "Passowrd field cannot be empty";

      }

      if($password != $password2) {

        return "Passwords do not match";

      }

      if(empty($email)) {

        return "Email field cannot be empty";

      }

      if(empty($fname)) {

        return "Firstname field cannot be empty";

      }

      if (empty($lname)){

        return "Email field cannot be empty";

      }

      if(empty($background)){

        return "Background field cannot be empty";

      }

      if(empty($role)){

        return "Role field cannot be empty";

      }
                    
      if(empty($skills) || count(explode(",", $skills))<1) {

        return "You must add at least one skill";

      }

      // Set account data
      $this->password = $password;
      $this->email = $email;
      $this->fname = $fname;
      $this->lname = $lname;
      $this->role = $role;
      $this->background = $background;
      $this->skills = $skills;

      return true;
    
    }

}

?>