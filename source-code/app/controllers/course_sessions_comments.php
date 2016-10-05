<?php

	// Receive http request from client with a new comment to post

	// Start session
	require_once '../models/session.php';

	// Check if the user has the rights to perform this operation
	//if(!$_SESSION['role'] === "mentor"){
	//	exit("You are not allowed to make these changes.");
	//}

	// Check if the parameter is set
	if( !isset($_POST['s_id']) || empty($_POST['s_id']) ||
		(isset($_POST['delete']) && (!isset($_POST['comment_id']) || empty($_POST['comment_id'])) ) ||
	    (isset($_POST['new']) && (!isset($_POST['comment_text']) || empty($_POST['comment_text'])) ) ){
		exit("Some parameter is missing.");
	}

	// Include Course sessions functions
	require_once '../models/CourseSessions_Functions.php';
	$cs_func = new CourseSessions_Functions();	

	if(isset($_POST['delete'])){
		// Delete comment
		$response = $cs_func->comment($_SESSION['id'], $_POST['s_id'], null, TRUE, $_POST['comment_id']);
	} else {
		// Save comment
		$response = $cs_func->comment($_SESSION['id'], $_POST['s_id'], $_POST['comment_text']);	
	}
	
	if ( $response ){
		echo "ok";
	} else {
		echo "Error while saving data, please try again.";
	}

?>