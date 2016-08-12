<?php
 
class Project_Functions {
 
    var $project_id;
    var $account_id;

    // constructor
    function __construct($account,$project) {
        $this->account_id = $account;
        $this->project_id = $project;
        // connecting to database
        require_once 'database/DB_Connect.php';
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         $this->conn->close();
    }
 

    /**
     * Check User rights to edit the project
     */
    public function userProjectRights() {

        $query = "SELECT p.id, p.title, p.description, p.vision, p.team_id
                  FROM "._T_TEAM_ACCOUNT." ta, "._T_PROJECT." p, "._T_TEAM." team
                  WHERE ta.account_id=".$this->account_id."
                  AND p.id=".$this->project_id."
                  AND ta.team_id=team.id
                  AND p.team_id=team.id";

        $result = $this->conn->query($query);

        // There must be only one row result
        // because a team can have only one project a time
        if ($result->num_rows == 1) {
            // user has the rights to edit the project 
            $project_data = $result->fetch_assoc();
            return $project_data;
        } else {
            // user has no rights on this project
            return false;
        }
    }

    /**
     * ...
     */
    public function currentProjectMilestones() {

        $milestones_data = [];

        // Store all the milestones in the array
        $query = "SELECT id, name FROM "._T_MILESTONE.";";
        
        $result = $this->conn->query($query);
 
        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()){
                $milestones_data[$row['id']] = ["name"=>$row['name']];
            }

            $query = "SELECT m.id, m.name, pm.update_date
                      FROM "._T_PROJECT_MILESTONE." pm, "._T_MILESTONE." m
                      WHERE pm.project_id=".$this->project_id."
                      AND m.id = pm.milestone_id";

            $result = $this->conn->query($query);
     
            if ($result->num_rows > 0) {
                
                // Insert into data[] all the milestones reached
                while($row = $result->fetch_assoc()){
                    $milestones_data[$row['id']] = ["name"=>$row['name'],"date"=>$row['update_date']];
                }

            }

            return $milestones_data;
        
        } else {
        
            // No milestones have been found
            return NULL;
        
        }

    }

    /**
     * Update project details
     */
    public function updateProject($title,$description,$vision) {

        $query = "UPDATE "._T_PROJECT." 
                  SET updated_date=NOW(),
                      title='".$title."',
                      description='".$description."',
                      vision='".$vision."'
                  WHERE id='".$this->project_id."'";

        $result = $this->conn->query($query);
 
        // Only one row must be affected (remember: only one project each team)
        if ($this->conn->affected_rows == 1) {

            // Project have been succenfully updated
            // Return the new project details
            return $this->userProjectRights();

        } else {

            // Error, project not updated
            return NULL;

        }


    }

    /**
     * Update milestones
     */
    public function addMilestones($milestones) {

        $query = "";

        foreach ($milestones as $key => $milestone_id) {
            $query .= "INSERT INTO "._T_PROJECT_MILESTONE."
                       VALUES ('".$this->project_id."','".$milestone_id."',NOW());";
        }
 
        // Check if all milestones have been added
        if($this->conn->multi_query($query)) {
            
            $i = 0;

            do {
                $this->conn->next_result();
                $i++;
            } while($this->conn->more_results());
            
            if($i != count($milestones)) echo "Only $i milestones have been updated.";

            // Milestones have been updated            
            // Return the current milestones
            return $this->currentProjectMilestones();

        } else {
            
            // Error, project not updated
            return NULL;

        }

    }

}
 
?>