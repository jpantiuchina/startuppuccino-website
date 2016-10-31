<?php
 
class Educators_Functions {
 
    var $account_id;
    var $ideas_func;

    function __construct($account) {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        // Set the account_id
        $this->account_id = $account;
        // Initialize the ideas functions object
        require_once 'Ideas_Functions.php';
        $this->ideas_func = new Ideas_Functions($this->account_id);
    }
 
    function __destruct() {
        $this->conn->close();
    }
 
    /**
     * Approve the selected idea
     */
    public function approveIdea($idea_id) {

      $query = "UPDATE "._T_IDEA." SET is_approved=TRUE WHERE id='".$idea_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        return "Idea approved";
      }

      return "Something went wrong";

    }

    /**
     * Disapprove the selected idea
     */
    public function disapproveIdea($idea_id) {

      $query = "UPDATE "._T_IDEA." SET is_approved=FALSE WHERE id='".$idea_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        return "Idea disapproved";
      }

      return "Something went wrong";

    }

    /**
     * Create a new team/project based on the selected idea
     */
    public function upgradeIdea($idea_id) {

      return $this->approveIdea($idea_id);

    }

}

?>