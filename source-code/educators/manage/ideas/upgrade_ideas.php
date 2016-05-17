<?php

	require_once '../../../assets/php/session.php';

	// Check if the current user is an "educator"
	if($_SESSION['role'] == "educator"){

		if(isset($_POST['idea_id'])){

			// Initialize the educators functions
			require_once '../../../assets/php/Educators_Functions.php';
			$edu_func = new Educators_Functions($_SESSION['id']);

			$response = $edu_func->upgradeIdea($_POST['idea_id']);

			echo $response;

		} else {

			die("No idea selected");

		}

	} else {

		die("You cannot do this!");

	}

?>