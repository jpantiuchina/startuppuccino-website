<?php
	
	include '../assets/php/session.php';
	
	$response = "Error... please try again";

	if(isset($_POST['key'])){

		// connect db
		include '../assets/php/db_connect.php';

		switch ($_POST['key']) {
			case 'join_idea':
				$query = "INSERT INTO IdeaAccount (idea_id,account_id,date) VALUE ('".$_POST['idea_id']."','".$_SESSION['id']."',NOW());";
				break;
			case 'new_idea':
				// TODO: add check for only positive integer values for team_size
				if(isset($_POST['team_size'])) $team_size = $_POST['team_size'];
				else $team_size = 2;
				$query = "INSERT INTO Ideas (title,owner_id,team_size,description,date,background_pref)
						  VALUE ('".$_POST['title']."','".$_SESSION['id']."','".$team_size."','".$_POST['description']."',NOW(),'".$_POST['background_pref']."')";
				break;
			default:
				die("Error, no key match");
		}

		// Execute the query
		if($result = mysqli_query($dbconn,$query)){
			
			// evaluate query response
			// ...
			$response = "ok";

		} else {

			// error -> query not executed
			$response = "Error.. query not executed, please try again.\n".mysqli_error($dbconn);

		}


	} else {

		// No parameter key is set so nothing happens
		echo "...\n";

	}

	echo $response;

?>