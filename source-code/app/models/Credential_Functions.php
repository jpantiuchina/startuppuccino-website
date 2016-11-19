<?php

require_once dirname( __DIR__ ) . '/controllers/session.php';

class Credential_Functions {
 
    private $email,
            $password,
            $fname,
            $lname,
            $background,
            $role,
            $skills;

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

      $query = "SELECT id, about, avatar, background, skills, email, firstname, lastname, role 
                FROM "._T_ACCOUNT." 
                WHERE email='" . $this->email . "' 
                AND password='" . $this->password . "'";

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
     * Set Permanent Login
     */
    public function setPermaLogin($account_id) {

      $cookie_token = $this->generateCookieToken($account_id);

      if($this->issetPermaLogin($cookie_token)){

        // Cookie is already present, maybe the user deleted the cookie on the browser
        return $cookie_token;

      } else {

        $query = "INSERT INTO "._T_ACCOUNT_LOGGED." (account_id, cookie_token)
                  VALUES ('" . $account_id . "','" . $cookie_token . "');";
      
      }

      $result = $this->conn->query($query);

      if($this->conn->affected_rows != 1){

        // Reset cookie token
        $cookie_token = "";

      }
      
      return $cookie_token;

    }

    /**
     * Check if user permalogin cookie is already in the db
     * Return if the perma login is already set or not
     */
    public function issetPermaLogin($cookie_token) {
      
      $query = "SELECT account_id
                FROM "._T_ACCOUNT_LOGGED."
                WHERE cookie_token='" . $cookie_token . "';";

      $result = $this->conn->query($query);

      if($result && $result->num_rows == 1 ){
            
        return true;

      }

      return false;

    }


    /**
     * Generate a new cookie token
     * temporary the cookie is generated as the hash
     * of the account id, a default "key" and user_agent
     */
    private function generateCookieToken($account_id) {

      return md5( $account_id . "startuppuccino" . $_SERVER['HTTP_USER_AGENT'] );

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
    public function validateInputs($password, $password2, $email, $fname, $lname, $background, $role, $skills) {

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


    /**
     * Reset Password
     */
    public function reset_password(){
    
      if(!$this->emailExists()){
        return false;
      }

      $new_password = $this->generateNewPassword();

      $query = "UPDATE "._T_ACCOUNT." 
                SET password='".$new_password."'
                WHERE email='".$this->email."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1){

        mail($this->email,
             "New Password - Startuppuccino",
             "We have successfully reset the password please\n\n".$idea_link,
             "From: Startuppuccino - Lean Startup <info@startuppuccino.com>");

        return true;
      }

      return false;

    }   

    /**
      * Generate a temporary new password
      */ 
    public function generateNewPassword(){
      return md5("startuppuccino");
    }

}

?>