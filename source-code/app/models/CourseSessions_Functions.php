<?php
 
class CourseSessions_Functions {

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
     * Scan session documents directory and get resources
     */
    private function loadResources($sessions_array){
        
        // Scan all resources files
        $files = scandir("../app/assets/docs/session/");

        // Check if there is at least one resource
        // Remember: scandir, in linux environment, count also the default folders "." and ".."
        // (that's way the condition is >2)
        if(count($files)>2){
            // Load resources on the session array associated to the relative session
            $l = count($sessions_array);
            for ($i = 0; $i < $l; $i++) {

                $file_prefix = $sessions_array[$i]['date']."_week_";
                $prefix_length = count($file_prefix);
                foreach ($files as $file) {
                    if(substr($file, 0, $prefix_length) === $file_prefix){
                        $sessions_array[$i]['resources'][] = $file;
                    }
                }
            
            }
        }

        return $sessions_array;

    }

    /**
     * Scan session documents directory and get resources
     */
    private function loadHosts($sessions_array){
        
        $query = "SELECT ma.mentor_id, a.avatar
                  FROM "._T_MENTOR_AVAILABILITY." ma, "._T_ACCOUNT." a
                  WHERE ma.mentor_id = a.id
                  GROUP BY session_id ;";

        $result = $this->conn->query($query);

        $hosts = [];

        if($result){

            while ($host = $result->fetch_assoc()){
                $hosts[] = ["id"=>$host['mentor_id'],
                            "avatar"=>$host['avatar']];
            }

            if(count($hosts) > 0){
                $sessions_array['hosts'] = $hosts;
            }

        }

        return $sessions_array;

    }

    /**
     * Get all Sessions
     */
    public function getSessions(){
    
        $sessions = [];

        $query = "SELECT s.id, s.title, s.date, s.description 
                  FROM "._T_SESSION." s;";

        $result = $this->conn->query($query);

        if($result){

            while ($sesssion = $result->fetch_assoc()){
                $sessions[] = $sesssion;
            }

            if(count($sessions) > 0){
                // Fill sessions array with resources data
                $sessions = $this->loadResources($sessions);
            }

        }

        return $sessions;

    }

    /**
     * Edit mentor availability
     */
    public function editMentorAvailability($mentor_id, $session_id, $action){

        if ($action === "add"){

            $query = "INSERT INTO "._T_MENTOR_AVAILABILITY." (mentor_id, session_id)
                      VALUES ('".$mentor_id."', '".$session_id."');";

        } else if ($action === "remove"){

            $query = "DELETE FROM "._T_MENTOR_AVAILABILITY."
                      WHERE mentor_id = '".$mentor_id."'
                      AND session_id = '".$session_id."' ;";

        } else {
            return false;
        }

        $this->conn->query($query);

        if($this->conn->affected_rows === 1 ){

            return true;

        }

        return false;

    }

    /**
     * Edit mentor availability
     */
    public function getMentorSessionAvailability($mentor_id){

        $sessions = [];

        $query = "SELECT ma.session_id 
                  FROM "._T_MENTOR_AVAILABILITY." ma
                  WHERE ma.mentor_id = '".$mentor_id."';";

        $result = $this->conn->query($query);

        if($result){

            while ($sesssion = $result->fetch_assoc()){
                $sessions[] = $sesssion['session_id'];
            }

        }

        return $sessions;

    }

}

?>