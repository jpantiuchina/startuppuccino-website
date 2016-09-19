<?php

	// Receive http request from client with the changes to apply to mentor availability

	// Start session
	require_once '../models/session.php';

	// Check if the user has the rights to perform this operation
	if(!$_SESSION['role'] === "mentor"){
		exit("You are not allowed to make these changes.");
	}

	// Check if the parameter is set
	if(!isset($_POST['s_id']) || empty($_POST['s_id']) ||
	   !isset($_POST['action']) || empty($_POST['action']) ){
		exit("Some parameter is missing.");
	}

	// Include Course sessions functions
	require_once '../models/CourseSessions_Functions.php';
	$cs_func = new CourseSessions_Functions();

	// Edit availability
	if ($cs_func->editMentorAvailability($_SESSION['id'], $_POST['s_id'], $_POST['action'])){

		// Edit the session array
		if($_POST['action'] === "add"){
			array_push($_SESSION['lectures_availability'], $_POST['s_id']);
		} else if($_POST['action'] === "remove"){
			unset(
				$_SESSION['lectures_availability'][array_search($_POST['s_id'], $_SESSION['lectures_availability'])]
				);
		}

		// Exit with successful answer
		exit("ok");
	}

	echo "Error while saving data, please try again.";


?>