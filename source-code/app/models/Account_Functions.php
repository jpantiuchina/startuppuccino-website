<?php
 
class Account_Functions {
 
    var $account_id;
    var $account_data;

    // constructor
    function __construct($account) {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->account_id = $account;
        $this->account_data = $this->readAccountData();
    }
 
    // destructor
    function __destruct() {
        $this->conn->close();
    }
 
    /**
     * Read the user data from the database
     */
    public function readAccountData() {

      $query = "SELECT * FROM Account WHERE id='".$this->account_id."';";

      $result = $this->conn->query($query);

      if($result){

        // Return the array of data
        return $result->fetch_assoc();

      }
      
      // No account found
      // Return an empty array
      return [];

    }

    /**
     * Get the account role
     */
    public function getRole() {
    	return $this->account_data['role'];
    }


    /**
     * Update Account Data
     */
    public function updateAccount($email,$firstname,$lastname,$background,$role,$about) {
      
      // Should be better here to doublecheck if some parameters is empty (not required now)

      $query = "UPDATE Account SET
                      email='".$email."',
                      firstname='".$firstname."',
                      lastname='".$lastname."',
                      background='".$background."',
                      role='".$role."',
                      about='".$about."' 
                      WHERE id='".$this->account_id."';";

      $this->conn->query($query);

      if($this->conn->affected_rows == 1){

        return true;

      } else {

        return false;

      }

    }



    /**
     * Update User Password
     */
    public function updatePassword($old_password,$new_password) {
        
      if ($old_password != $new_password || $new_password != "") {

        $query = "UPDATE Account SET password='".md5($new_password)."' WHERE id='".$this->account_id."' AND password='".md5($old_password)."';";

        $this->conn->query($query);

        if ($this->conn->affected_rows == 1) {

          return true;

        }
      
      }

      return false;

    }

    /**
     *  Save New Social Data
     */
    public function saveSocialdata($socialdata) {

      if(!empty($socialdata)){

        $query = "UPDATE Account SET socials='".$socialdata."' WHERE id='".$this->account_id."';";

        $this->conn->query($query);

        if ($this->conn->affected_rows == 1) {

          return "ok";

        }

      }

      return "Error while saving data, please try again.";

    }

}

?>