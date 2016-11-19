<?php
 
class Search_Functions {

    private $result_set;

    function __construct() {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->result_set = $this->loadResults();
    }

    function __destruct() {
        $this->conn->close();
    }

    /**
     * Return a json object with all results
     */
    public function getAll(){
        
        $result_set = [];
        foreach ($this->result_set as $key => $value) {
            $result_set[$key] = array_map("utf8_encode", $value);
        }

        return json_encode($result_set);

    }

    /**
     * Get all results (People,Projects, Ideas)
     * Temporary only people and ideas, TODO -> finish after new db is ready
     */
    private function loadResults(){
        
        $users = $this->loadUsers();
        $ideas = $this->loadIdeas();

        $result = $users;

        if(count($ideas) > 0){
            foreach ($ideas as $idea) {
                array_push($result, $idea);
            }
        }

        return $result;

    }

    /**
     * Get all Users
     */
    private function loadUsers(){
    
        $query = "SELECT id, firstName, lastName, role, avatar  FROM "._T_ACCOUNT.";";

        $result = $this->conn->query($query);

        if($result){

            while ($user = $result->fetch_assoc()){

                $users[] = ["id"=>"people/?user_id=" . $user['id'],
                            "name"=>$user['firstName']." ".$user['lastName'],
                            "role"=>$user['role'],
                            "avatar"=>"people/" . $user['avatar']];

            }

            return $users;

        }

        // No result found [should never reach this point]
        // Return an empty array
        return [];

    }

    /**
     * Get all Ideas
     */
    private function loadIdeas(){
    
        $query = "SELECT id, title, avatar  FROM "._T_PROJECT;

        $result = $this->conn->query($query);

        $ideas = [];

        if($result){

            while ($idea = $result->fetch_assoc()){

                $ideas[] = ["id"=>"ideas/#i" . $idea['id'],
                            "name"=>$idea['title'],
                            "role"=>"",
                            "avatar"=>"ideas/" . $idea['avatar']];

            }

        }

        return $ideas;

    }
}

?>