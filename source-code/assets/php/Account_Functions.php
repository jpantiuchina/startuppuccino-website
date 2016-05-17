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
    private function readAccountData() {

      $query = "SELECT * FROM Account WHERE account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      if($result->num_rows == 1){

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

}

?>