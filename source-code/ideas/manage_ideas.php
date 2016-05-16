<?php
	
	require '../assets/php/session.php';
	
	// Default response
	$response = "Error... please try again";

	if(isset($_POST['key'])){

		// connect db
		require '../assets/php/db_connect.php';

		// Include and Initialize People Functions
		require_once '../assets/php/Ideas_Functions.php';
		$ideas_func = new Ideas_Functions($_SESSION['id']);

		// Set the current idea
		$ideas_func->setIdea($_POST['idea_id']);

		switch ($_POST['key']) {

			case 'join_idea':

				$response = $ideas_func->joinIdea();
				break;
			
			case 'leave_idea':
			
				$response = $ideas_func->leaveIdea();
				break;
			
			case 'new_idea':
			
				$response = $ideas_func->newIdea($_POST['title'],
												 $_POST['team_size'],
												 $_POST['description'],
												 $_POST['background_pref']);
				break;

			case 'teamsize':
			
				$response = $ideas_func->getTeamsize();
				break;
			
			case 'delete_idea':
				
				$response = $ideas_func->deleteIdea();
				break;

			default:
				die("Error, no key match");

		}

	} else {

		// No parameter key is set so nothing happens
		echo "...";

	}

	echo $response;

?>