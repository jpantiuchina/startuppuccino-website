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
                // Fill sessions array with comments
                $sessions = $this->loadComments($sessions);
            }

        }

        return $sessions;

    }

    /**
     * Edit mentor availability
     */
    public function editMentorAvailability($mentor_id, $session_id, $action, $pitch = null, $pitch_title = null){

        // action = remove -> yes is enabled and tuple is in the table
        // action = add -> no is enabled and tuple is not in the table

        // Pitch title is required when applying for a pitch
        if($pitch === "1" && $pitch_title == null){
          return false;
        }

        if ($action === "remove") {

            if ($pitch === "0") {

                $query = "UPDATE "._T_MENTOR_AVAILABILITY." 
                      SET pitch='0', pitch_title='', pitch_approved=NULL
                      WHERE mentor_id='".$mentor_id."' 
                      AND session_id='".$session_id."';";

            } else if ($pitch === "1") {
                
                $query = "UPDATE "._T_MENTOR_AVAILABILITY." 
                      SET pitch='1', pitch_title='".$pitch_title."'
                      WHERE mentor_id='".$mentor_id."' 
                      AND session_id='".$session_id."';";

            } else {

                $query = "DELETE FROM "._T_MENTOR_AVAILABILITY."
                      WHERE mentor_id = '".$mentor_id."'
                      AND session_id = '".$session_id."' ;";

            }

        } else if ($action === "add") {

            if ($pitch === "1") {

                $query = "INSERT INTO "._T_MENTOR_AVAILABILITY." (mentor_id, session_id, pitch, pitch_title)
                          VALUES ('".$mentor_id."', '".$session_id."', 1, '".$pitch_title."');";            

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
     * Store a new comment
     */
    public function comment($author_id, $session_id, $comment_text, $delete = null, $comment_id = null){

        if( $delete === TRUE && $comment_id != null){

          $query = "DELETE FROM "._T_SESSION_COMMENT."
                    WHERE author_id = '".$author_id."'
                    AND session_id = '".$session_id."'
                    AND id = '".$comment_id."';";

        } else {

          $query = "INSERT INTO "._T_SESSION_COMMENT." (session_id, author_id, text)
                    VALUES ('".$session_id."', '".$author_id."','".$comment_text."');";            

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

        $query = "SELECT ma.session_id, ma.pitch, ma.pitch_approved, ma.pitch_title
                  FROM "._T_MENTOR_AVAILABILITY." ma
                  WHERE ma.mentor_id = '".$mentor_id."';";

        $result = $this->conn->query($query);

        if($result){

            while ($session = $result->fetch_assoc()){
                
                if ($session['pitch'] == "0"){
                  $sessions[$session['session_id']][0] = 0;  
                } else if ( $session['pitch'] == "1" && $session['pitch_approved'] == null ){
                  $sessions[$session['session_id']][0] = 1;
                } else if ( $session['pitch'] == "1" && $session['pitch_approved'] == "0" ){
                  $sessions[$session['session_id']][0] = 2;
                } else if ( $session['pitch'] == "1" && $session['pitch_approved'] == "1" ){
                  $sessions[$session['session_id']][0] = 3;
                }

                $sessions[$session['session_id']][1] = $session['pitch_title'];

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
                      FROM "._T_MENTOR_AVAILABILITY." AS ma 
                      JOIN "._T_ACCOUNT." AS a 
                      ON ma.mentor_id = a.id
                      WHERE ma.session_id = ".$sessions_array[$i]['id'].";";

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
     * Load comments for each lecture/session
     */
    private function loadComments($sessions_array){
        

        foreach ($sessions_array as $i => $session_value) {

            $query = "SELECT c.id, 
                             c.text,
                             c.author_id,
                             a.avatar as author_avatar
                      FROM "._T_SESSION_COMMENT." AS c
                      JOIN "._T_ACCOUNT." AS a
                      ON c.author_id = a.id
                      WHERE c.session_id = ".$sessions_array[$i]['id'].";";
                      
            $result = $this->conn->query($query);

            $comments = [];

            if($result){

                while ($comment = $result->fetch_assoc()){
                    $comments[] = $comment;
                }

                if(count($comments) > 0){
                    $sessions_array[$i]['comments'] = $comments;
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