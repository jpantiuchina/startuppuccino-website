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
			
			case 'delete_idea':
				
				// First check if the current user is truly the idea owner	
				$owner_check = mysqli_query($dbconn,"SELECT owner_id FROM Ideas WHERE id='".$_POST['idea_id']."';");

				if($owner_check && mysqli_num_rows($owner_check)==1){

					$owner_check_id = mysqli_fetch_assoc($owner_check)['owner_id'];
					if($owner_check_id == $_SESSION['id']){
						// The current user is the owner of the idea so we can go on and delete the idea
						$query = "DELETE FROM Ideas WHERE id='".$_POST['idea_id']."' AND owner_id='".$_SESSION['id']."';";
						$query .= "DELETE FROM IdeaAccount WHERE idea_id='".$_POST['idea_id']."';";

						if(mysqli_multi_query($dbconn,$query)) $response = "ok";
						else $response = "Error while deleting the idea ";

					} else {
						$response = "You are not the idea owner!";
						// Here add an alert to tell educators someone was trying to break the platform
					}

				} else {
					$response = "Something went wrong... are you the owner of this idea?";
				}

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