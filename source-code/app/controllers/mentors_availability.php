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

	// Set pitch value
	$pitch = (isset($_POST['pitch']) && in_array($_POST['pitch'], ["0","1"])) ? $_POST['pitch'] : null;

	// Include Course sessions functions
	require_once '../models/CourseSessions_Functions.php';
	$cs_func = new CourseSessions_Functions();	

	// Check if pitch paramenter is set with the right value ( 0 or 1 )
	if($pitch != null) {

		// Pitch title is required
		if($pitch === "1" && ( !isset($_POST['pitch_title']) || trim($_POST['pitch_title']) === "" ) ){
			exit("Pitch title is missing.");
		}

		$edit_availability = $cs_func->editMentorAvailability($_SESSION['id'], 
			                                                  $_POST['s_id'], 
			                                                  $_POST['action'],
			                                                  $_POST['pitch'],
			                                                  $_POST['pitch_title']);
		
	} else {
		
		$edit_availability = $cs_func->editMentorAvailability($_SESSION['id'], $_POST['s_id'], $_POST['action']);
	
	}

	// Edit availability
	if ($edit_availability){

		// Exit with successful answer
		exit("ok");
	
	} else if ($pitch === "0" && $_POST['action'] === "add"){
	
		exit("no");
	
	}

	echo "Error while saving data, please try again.";


?>