<?php
 
class Ideas_Functions {
 
    private $account_id;
    private $idea_id;
    private $my_ideas_id;
    private $LIKES_LIMIT;
    private $JOIN_LIMIT;

    public $user_likes;
    public $user_joins;

    // constructor
    function __construct($account) {
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
        $this->account_id = $account;
        $this->my_ideas_id = $this->readAllMyIdeasIDs();
        $this->user_likes = $this->loadUserLikes();
        $this->user_joins = $this->loadUserJoins();
        $this->LIKES_LIMIT = 3;
        $this->JOIN_LIMIT = 1;
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
     * Ranklist of ideas likes
     */
    public function getIdeaRanklist(){
      
      $query = "SELECT i.title, a.firstName, a.lastName, COUNT(l.id) AS tot_likes
                FROM "._T_IDEA_ACCOUNT." AS l
                JOIN "._T_IDEA." AS i 
                ON i.id=l.project_id
                JOIN "._T_ACCOUNT." AS a
                ON a.id=i.owner_id
                GROUP BY i.title
                ORDER BY tot_likes DESC;";

      $result = $this->conn->query($query);
      
      $ideas = [];

      if($result) {
        
        while ($idea = $result->fetch_assoc()){
          $ideas[] = $idea;
        }

      }
     
      return $ideas;

    }

    /**
     * Get the list of all ideas IDs that the current user joins
     * (more than if the user published more ideas)
     */
    private function loadUserJoins(){

      $query = "SELECT l.project_id FROM "._T_IDEA_ACCOUNT." AS l 
                WHERE l.account_id='".$this->account_id."';";

      $result = $this->conn->query($query);

      $temp_arr = [];

      if($result && $result->num_rows > 0) {
        while($ideajoin = $result->fetch_assoc()) {
          $temp_arr[] = $ideajoin['project_id'];
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
        $idea = $result->fetch_assoc();
        $ideas = $this->loadIdeaMembers([$idea]);
        return $ideas[0];
      }
     
      // No idea found
      return [];
     
    }

    /**
     * Get all idea members
     */
    private function loadIdeaMembers($ideas_array){

      foreach ($ideas_array as $i => $idea_value) {

          $query = "SELECT a.id, a.avatar, a.firstName, a.lastName
                    FROM "._T_IDEA_ACCOUNT." AS ia 
                    JOIN "._T_ACCOUNT." AS a 
                    ON ia.account_id = a.id
                    WHERE ia.project_id = ".$ideas_array[$i]['id'].";";

          $result = $this->conn->query($query);

          $members = [];

          if($result){

              while ($member = $result->fetch_assoc()){
                  $members[] = $member;
              }

              if(count($members) > 0){
                  $ideas_array[$i]['members'] = $members;
              }

          }

      }

      return $ideas_array;

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
                       (SELECT COUNT(*) FROM "._T_IDEA_COMMENT." WHERE project_id = i.id) AS num_of_comments,
                       i.created_at,
                       i.looking_for,
                       i.avatar,
                       a.firstName, 
                       a.lastName,
                       i.id,
                       i.owner_id,
                       i.is_approved,
                       (SELECT IF (COUNT(project_id)>0, 'unlike', 'like') vote
                        FROM "._T_IDEA_LIKE." WHERE account_id='".$this->account_id."' AND project_id=i.id) AS vote_label,
                       (SELECT IF (COUNT(project_id)>0, 'leave', 'join') vote
                        FROM "._T_IDEA_ACCOUNT." WHERE account_id='".$this->account_id."' AND project_id=i.id) AS i_joined
                FROM "._T_IDEA." i JOIN "._T_ACCOUNT." a ON i.owner_id = a.id;";

      $result = $this->conn->query($query);

      if($result && $result->num_rows > 0){

        while ($idea = $result->fetch_assoc()){
          $ideas[] = $idea;
        }

        if(count($ideas) > 0){
            // Fill with ideas members
            $ideas = $this->loadIdeaMembers($ideas);
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
      
      if(count($this->user_joins) >= $this->JOIN_LIMIT){
        return "You already joined an idea.";
      }

      $query = "INSERT INTO "._T_IDEA_ACCOUNT." (project_id, account_id, joined_at) 
                VALUE ('".$this->idea_id."', '".$this->account_id."', NOW());";

      if($this->conn->query($query) && $this->conn->affected_rows == 1){

        // Push idea_id to user likes
        $this->user_joins[] = $this->idea_id;
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
                                '$background_pref');

                        INSERT INTO "._T_IDEA_ACCOUNT." (project_id, account_id, joined_at) 
                        VALUE ((SELECT LAST_INSERT_ID()), '$this->account_id', NOW());";

              if ($this->conn->multi_query($query)) {
                  return "ok";
              }

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
    private function notify_new_comment($comment_text) {
      
      $query = "SELECT a.email, i.title, i.id
                FROM "._T_ACCOUNT." a 
                JOIN "._T_IDEA." i
                ON a.id=i.owner_id
                WHERE i.id='".$this->idea_id."'";

      $result = $this->conn->query($query);

      if($result && $result->num_rows == 1) {

        $r = $result->fetch_assoc();
        $author_email = $r['email'];
        $idea_link = "http://startuppuccino.com/ideas/#i".$r['id'];
        $idea_title = $r['title'];


        mail($author_email,
             "New Comment on".$idea_title,
             "You have a new comment on your idea! Go check it out on startuppuccino :)\n\n".$idea_link,
             "From: Startuppuccino - Lean Startup <info@startuppuccino.com>");
        mail("dev@startuppuccino.com",
             "New Comment on".$idea_title,
             "Comment: ".$comment_text."\n\n".$idea_link."\n\n ".$author_email,
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

    /**
     * Get idea data of the joined idea from the user
     */
    public function getJoinedIdea() {
      
      if( count($this->user_joins) != 1 ){
        return false;
      }

      // Get the joined idea
      $joined_idea_id = $this->user_joins[0];

      if($joined_idea_id){

        $this->setIdea($joined_idea_id);
        $joined_idea = $this->getIdeaData();

        if(count($joined_idea) > 0){

          return $joined_idea;

        }

      }

      return false;
    
    }

}

?>