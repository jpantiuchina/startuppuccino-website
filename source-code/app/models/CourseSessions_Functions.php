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
     * Get all Sessions
     */
    public function getSessions(){
    
        $sessions = [];

        $query = "SELECT s.id,
                         s.title,
                         s.date,
                         s.description,
                         s.resource
                  FROM "._T_SESSION." s;";

        $result = $this->conn->query($query);

        if($result){

            while ($session = $result->fetch_assoc()){
                $sessions[] = $session;
            }

            if(count($sessions) > 0){
                // Fill sessions array with guest mentors
                $sessions = $this->loadGuests($sessions);
            }

        }

        return $sessions;

    }

    /**
     * Edit mentor availability
     */
    public function editMentorAvailability($mentor_id, $session_id, $action, $pitch = null){

        // action = remove -> yes is enabled and tuple is in the table
        // action = add -> no is enabled and tuple is not in the table

        if ($action === "remove") {

            if ($pitch === "0") {

                $query = "UPDATE "._T_MENTOR_AVAILABILITY." 
                      SET pitch='0'
                      WHERE mentor_id='".$mentor_id."' 
                      AND session_id='".$session_id."';";

            } else if ($pitch === "1") {
                
                $query = "UPDATE "._T_MENTOR_AVAILABILITY." 
                      SET pitch='1'
                      WHERE mentor_id='".$mentor_id."' 
                      AND session_id='".$session_id."';";

            } else {

                $query = "DELETE FROM "._T_MENTOR_AVAILABILITY."
                      WHERE mentor_id = '".$mentor_id."'
                      AND session_id = '".$session_id."' ;";

            }

        } else if ($action === "add") {

            if ($pitch === "1") {

                $query = "INSERT INTO "._T_MENTOR_AVAILABILITY." (mentor_id, session_id, pitch)
                          VALUES ('".$mentor_id."', '".$session_id."',1);";            

            } else if($pitch === "0") {

                return false;

            } else {

                $query = "INSERT INTO "._T_MENTOR_AVAILABILITY." (mentor_id, session_id)
                          VALUES ('".$mentor_id."', '".$session_id."');";
            
            }

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
     * Get all the sessions when the mentor is available
     */
    public function getMentorSessionAvailability($mentor_id){

        $sessions = [];

        $query = "SELECT ma.session_id, ma.pitch
                  FROM "._T_MENTOR_AVAILABILITY." ma
                  WHERE ma.mentor_id = '".$mentor_id."';";

        $result = $this->conn->query($query);

        if($result){

            while ($session = $result->fetch_assoc()){
                $sessions[$session['session_id']] = $session['pitch'];
            }

        }

        return $sessions;

    }

     /**
     * Load mentor guest for each lecture/session
     */
    private function loadGuests($sessions_array){
        

        foreach ($sessions_array as $i => $session_value) {

            $query = "SELECT ma.mentor_id as id, a.avatar
                      FROM "._T_MENTOR_AVAILABILITY." ma, "._T_ACCOUNT." a
                      WHERE ma.mentor_id = a.id
                      AND ma.session_id = ".$sessions_array[$i]['id'].";";

            $result = $this->conn->query($query);

            $guests = [];

            if($result){

                while ($guest = $result->fetch_assoc()){
                    $guests[] = $guest;
                }

                if(count($guests) > 0){
                    $sessions_array[$i]['guests'] = $guests;
                }

            }

        }

        return $sessions_array;

    }

    /**
     * Scan session documents directory and get resources
     */
    /*
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
    */

}

?>