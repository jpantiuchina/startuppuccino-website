<?php
	
	require '../assets/php/session.php';
	
	// Default response
	$response = "Error... please try again";

	if(isset($_POST['key'])){

		// connect db
		require '../assets/php/db_connect.php';

		switch ($_POST['key']) {

			case 'join_idea':

				// TODO: add check if the user is the owner of the idea
				$query = "INSERT INTO IdeaAccount (idea_id,account_id,date) VALUE ('".$_POST['idea_id']."','".$_SESSION['id']."',NOW());";
				$query .= "UPDATE Ideas SET current_team_size = current_team_size + 1 WHERE id=".$_POST['idea_id'].";";

				if($result = mysqli_multi_query($dbconn,$query)) $response = "ok";
				else $response = "Error.. query not executed, please try again.\n".mysqli_error($dbconn);

				break;
			
			case 'leave_idea':
			
				// TODO: add check if the user is the owner of the idea
				$query = "DELETE FROM IdeaAccount WHERE idea_id='".$_POST['idea_id']."' AND account_id='".$_SESSION['id']."';";
				$query .= "UPDATE Ideas SET current_team_size = current_team_size - 1 WHERE id=".$_POST['idea_id'].";";

				if($result = mysqli_multi_query($dbconn,$query)) $response = "ok";
				else $response = "Error.. query not executed, please try again.\n".mysqli_error($dbconn);

				break;
			
			case 'new_idea':
			
				// TODO: add check for only positive integer values for team_size
				if(isset($_POST['team_size'])) $team_size = $_POST['team_size'];
				else $team_size = 2;
				$query = "INSERT INTO Ideas (title,owner_id,team_size,description,date,background_pref)
						  VALUE ('".$_POST['title']."','".$_SESSION['id']."','".$team_size."','".$_POST['description']."',NOW(),'".$_POST['background_pref']."');";
				
				if($result = mysqli_query($dbconn,$query)) $response = "ok";
				else $response = "Error.. query not executed, please try again.\n".mysqli_error($dbconn);

				break;

			case 'teamsize':
			
				$query = "SELECT id FROM IdeaAccount WHERE idea_id='".$_POST['idea_id']."'";

				if($result = mysqli_query($dbconn,$query)) $response = mysqli_num_rows($result);
				else $response = "Error.. query not executed, please try again.\n".mysqli_error($dbconn);

				break;
			
			default:
				die("Error, no key match");

		}

	} else {

		// No parameter key is set so nothing happens
		echo "...\n";

	}

	echo $response;

?>