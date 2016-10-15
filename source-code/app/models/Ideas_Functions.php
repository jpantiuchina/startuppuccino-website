<?php
 
class Ideas_Functions {
 
    private $account_id;
    private $idea_id;
    private $my_ideas_id;
    private $user_likes;
    private $LIKES_LIMIT;

    // constructor
    function __construct($account) {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->account_id = $account;
        $this->my_ideas_id = $this->readAllMyIdeasIDs();
        $this->user_likes = $this->loadUserLikes();
        $this->LIKES_LIMIT = 3;
    }
 
    // destructor
    function __destruct() {
        $this->conn->close();
    }

    /**
     * Set the idea
     */
    public function setIdea($idea) {
      $this->idea_id = $idea;
    }
 
    /**
     * Get the list of all ideas IDs owned by the current user
     */
    private function readAllMyIdeasIDs() {

      $query = "SELECT project_id FROM "._T_IDEA_ACCOUNT." WHERE account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        while ($idea = $result->fetch_assoc()){
          $ideas[] = $idea['project_id'];
        }

        // Return the array
        return $ideas;

      }
      
      // No ideas found
      // Return an empty array
      return [];

    }

    /**
     * Get the list of all ideas IDs that the current user liked
     */
    private function loadUserLikes(){

      $query = "SELECT l.project_id FROM "._T_IDEA_LIKE." AS l 
                WHERE l.account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      $temp_arr = [];

      if($result && $result->num_rows > 0) {
        while($idealike = $result->fetch_assoc()) {
          $temp_arr[] = $idealike['project_id'];
        }
      }
     
      return $temp_arr;

    }


    /**
     * Get the list of all ideas IDs owned by the current user
     */
    public function getAllMyIdeasID() {
      return $this->my_ideas_id;
    }

    /**
     * Get all the data of the current set idea
     */
    public function getIdeaData() {
      
      $query = "SELECT id, title, owner_id, description, avatar, looking_for, is_approved
                FROM "._T_IDEA." 
                WHERE id='".$this->idea_id."';";

      $result = $this->conn->query($query);

      if($result->num_rows == 1) {
        return $result->fetch_assoc();
      }
     
      // No idea found
      return [];
     
    }

    /**
     * Get all idea members
     */
    public function getIdeaMembers(){

      $query = "SELECT account_id FROM "._T_IDEA_ACCOUNT." WHERE project_id='".$this->idea_id."';";
      //$query = "SELECT id,skills FROM Account WHERE idea_selected='".$this->idea_id."';";

      $result = $this->conn->query($query);

      $idea_members = [];

      if($result->num_rows > 0) {

        // Fetch idea members into array
        while($member = $result->fetch_assoc()) {
          $idea_members[] = $member['account_id'];
        }
        
      }

      // Add the idea owner to the idea members (not included in the IdeaAccount table)
      $idea_members[] = $this->ideaOwnerID();

      return $idea_members;

    }

    /**
     * Check if the user is the idea owner
     */
    public function isMyIdea() {
      return in_array($this->idea_id, $this->my_ideas_id);
    } 

    /**
     * Get the list of all ideas
     */
    public function getAllIdeas() {

      $query = "SELECT i.title,
                       i.description,
                       i.ideal_team_size,
                       (SELECT COUNT(*) FROM "._T_IDEA_ACCOUNT." WHERE project_id = i.id) + 1 AS current_team_size,
                       i.created_at,
                       i.looking_for,
                       i.avatar,
                       a.firstName, 
                       a.lastName,
                       i.id,
                       i.owner_id
                    FROM "._T_IDEA." i JOIN "._T_ACCOUNT." a ON i.owner_id = a.id 
                    WHERE NOT i.is_approved;";

      $result = $this->conn->query($query);

      if($result && $result->num_rows > 0){

        while ($idea = $result->fetch_assoc()){
          $ideas[] = $idea;
        }

        // Return all ideas
        return $ideas;

      }
      
      // No ideas found
      return NULL;

    }

    /**
     * Update Idea Details
     */
    public function editIdea($title, $description, $avatar, $background_pref) {
      
      // Should be better here to doublecheck if some parameters is empty (not required now)

      // Temp fix
      $team_size = 2;

      // Clean inputs
      $title = trim($title);
      $team_size = intval($team_size);
      $description = trim($description);

      // Validate inputs
      if($title != "") {

        if($description != "") {

          if(strlen($description) < 141){
            
            if($team_size > 1) {

              $query = "UPDATE "._T_IDEA." 
                        SET title='".$title."',
                            owner_id='".$this->account_id."',
                            ideal_team_size='".$team_size."',
                            description='".$description."',
                            updated_at=NOW(),
                            avatar='".$avatar."',
                            background='".$background_pref."'
                        WHERE id='".$this->idea_id."';";

              $result = $this->conn->query($query);

              if($this->conn->affected_rows == 1) return "ok";

              return "Error, please try again.";

            } else {

              return "Team size cannot be less than 2.";

            }

          } else {

            return "Description cannot exced 140 characters.";

          }

        } else {
          
          return "Description is empty.";

        }

      } else {

        return "Title is empty.";

      }

    }

    /**
     * Join Idea
     */
    public function joinIdea() {
      
      $query = "INSERT INTO "._T_IDEA_ACCOUNT." (project_id, account_id, joined_at) 
                VALUE ('".$this->idea_id."', '".$this->account_id."', NOW());";

      if($this->conn->query($query) && $this->conn->affected_rows == 1){

        return "ok";

      }
      
      return "Error";

    }

    /**
     * Leave Idea
     */
    public function leaveIdea() {
      
      // The idea owner cannot leave the idea
      if($this->account_id == $this->ideaOwnerID()) {
        return "You are the owner! You cannot leave the idea.";
      }

      $query = "DELETE FROM "._T_IDEA_ACCOUNT." 
                WHERE project_id='".$this->idea_id."' 
                AND account_id='".$this->account_id."';";
      
      if($this->conn->query($query)){


            return "ok";

      }

      return "Error";

    }

    /**
     * Get the selected idea owner
     */
    private function ideaOwnerID() {
      
      $query = "SELECT owner_id 
                FROM "._T_IDEA." WHERE id='".$this->idea_id."';";
        
      $result = $this->conn->query($query);

      if($result->num_rows > 0){

        return $result->fetch_assoc()['owner_id'];

      }

      return NULL;

    }

    /**
     * Get team size
     */
    public function getTeamsize() {
      
      $query = "SELECT id FROM "._T_IDEA_ACCOUNT." 
                WHERE project_id='".$_POST['idea_id']."'";

      $result = $this->conn->query($query);

      if($result->num_rows >= 0) {

        return $result->num_rows;

      } else {

        return "Error, nothing found";

      }

    }

    /**
     * Create a new Idea
     */
    public function newIdea($title, $description, $avatar, $background_pref) {

      // Temp fix
      $team_size = 2;

      // Clean inputs
      $title = trim($title);
      $team_size = intval($team_size);
      $description = trim($description);

      // Validate inputs
      if($title != "") {

        if($description != "") {

          if(strlen($description) < 141){
            
            if($team_size > 1) {

              $query = "INSERT INTO "._T_IDEA." (title, owner_id, ideal_team_size, description, avatar, looking_for)
                        VALUES ('$title',
                                '$this->account_id',
                                '$team_size',
                                '$description',
                                '$avatar',
                                '$background_pref');";

              $result = $this->conn->query($query);

              if($this->conn->affected_rows == 1) return "ok";

              return "Error, please try again.";

            } else {

              return "Team size cannot be less than 2.";

            }

          } else {

            return "Description cannot exced 140 characters.";

          }

        } else {
          
          return "Description is empty.";

        }

      } else {

        return "Title is empty.";

      }
      
    }

    /**
     * Delete Idea
     */
    public function deleteIdea() {
      
      // Check idea ownership
      if($this->account_id != $this->ideaOwnerID()) {
        return "You are not the owner!";
      }

      // Delete the idea
      $query = "DELETE FROM "._T_IDEA." 
                WHERE id='".$this->idea_id."' 
                AND owner_id='".$this->account_id."';";
      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1){

        $team_size = $this->getTeamsize();

        $query = "DELETE FROM "._T_IDEA_ACCOUNT." 
                  WHERE project_id='".$this->idea_id."';";
        $result = $this->conn->query($query);

        if($this->conn->affected_rows == $team_size){

          return "ok";

        }

        $team_size_deleted = $this->conn->affected_rows;
        return "Idea not correctly deleted. Only $team_size_deleted/$team_size members deleted.";

      }

      return "It was not possible to delete the idea, please try later.";

    }


    /**
     * Get comments related to current selected idea
     */
    public function getComments() {
      
      $query = "SELECT ic.id, ic.project_id, ic.author_id, ic.text, a.avatar as author_avatar,
                       a.firstName as author_firstname, a.lastName as author_lastname
                FROM "._T_IDEA_COMMENT." AS ic, "._T_ACCOUNT." AS a
                WHERE ic.author_id = a.id 
                AND project_id='".$this->idea_id."'
                ORDER BY ic.id DESC;";  

      $result = $this->conn->query($query);

      if($result->num_rows > 0) {

        while ($comment = $result->fetch_assoc()){
          $comments[] = $comment;
        }

        // Return all ideas
        return $comments;

      }
     
      // No comments found
      return [["text"=>"No comments yet"]];
     
    }


    /**
     * Delete comment
     */
    public function deleteComment($comment_id) {
      
      $query = "DELETE FROM "._T_IDEA_COMMENT." 
                WHERE id='".$comment_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        return "ok";
      }
     
      // Error in the query
      return "Error while deleting the comment.";
     
    }


    /**
     * New comment on the current idea
     */
    public function newComment($comment) {
      
      $query = "INSERT INTO "._T_IDEA_COMMENT." (project_id, author_id, text, commented_at)
      			    VALUES ('".$this->idea_id."', '".$this->account_id."', '".$comment."', NOW());";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {

        // Send notification email
        $this->notify_new_comment($comment);

        return "ok";
      }
     
      // Error in the query
      return "Error while saving your new comment.";
     
    }


    /**
     * Send email to idea author to notify the new comment
     */
    public function notify_new_comment($comment_text) {
      
      $query = "SELECT a.email 
                FROM "._T_ACCOUNT." a, "._T_IDEA." i
                WHERE a.id=i.author_id
                AND i.id='".$this->idea_id."'";

      $result = $this->conn->query($query);

      if($result->num_rows == 1){

        $author_email = $result->fetch_assoc()['email'];

        mail("mondial95@gmail.com",
             "Startuppuccino - New Comment",
             $comment_text."\n ".$author_email,
             "From: Startuppuccino - Lean Startup <info@startuppuccino.com>");

      }
     
    }



    /**
     * Like the current idea
     */
    public function like() {
      
      if(count($this->user_likes) >= $this->LIKES_LIMIT){
        return "You have reached the maximum number of likes.";
      }

      $query = "INSERT INTO "._T_IDEA_LIKE." (project_id, account_id) 
                VALUES ('".$this->idea_id."', '".$this->account_id."');";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        // Push idea_id to user likes
        $this->user_likes[] = $this->idea_id;
        return "ok";
      }
     
      // Error in the query
      return "Error";
     
    }


    /**
     * Unlike the current idea
     */
    public function unlike() {
      
      $query = "DELETE FROM "._T_IDEA_LIKE." 
                WHERE account_id='".$this->account_id."' AND project_id='".$this->idea_id."';";

      $result = $this->conn->query($query);

      if($this->conn->affected_rows == 1) {
        // Pop idea_id to user likes
        $temp_user_likes = [];
        foreach ($this->user_likes as $idea_id) {
          if($idea_id != $this->idea_id){
            $temp_user_likes[] = $idea_id;
          }
        }
        $this->user_likes = $temp_user_likes;
        return "ok";
      }
     
      // Error in the query
      return "Error";
     
    }

    /**
     * Get list of account IDs that liked the current idea
     */
    public function getIdeasLikes() {
    
      $query = "SELECT account_id FROM "._T_IDEA_LIKE." 
                WHERE project_id='".$this->idea_id."';";

      $result = $this->conn->query($query);

      if($result->num_rows > 0) {
        return $result->fetch_assoc();
      }
     
      // No likes found
      return [];
    
    }

    /**
     * Get list of ideas IDs that the current user liked
     */
    public function getUserLikes() {
    
      return $this->user_likes;
    
    }

}

?>