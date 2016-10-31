<?php

	require_once '../../../app/models/session.php';

	// Check if the current user is an "educator"
	if($_SESSION['role'] == "educator"){

		if(isset($_POST['idea_id']) && isset($_POST['action']) && !empty($_POST['action'])){

			// Initialize the educators functions
			require_once '../../../app/models/Educators_Functions.php';
			$edu_func = new Educators_Functions($_SESSION['id']);

			if($_POST['action']=="approve"){
				$response = $edu_func->approveIdea($_POST['idea_id']);
			} else if($_POST['action']=="disapprove"){
				$response = $edu_func->disapproveIdea($_POST['idea_id']);
			}

			echo $response;

		} else {

			echo "Some parameters are missing";

		}

	} else {

		echo "You cannot do this!";

	}

?>