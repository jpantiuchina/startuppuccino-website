<?php
	
	require_once '../models/session.php';


	if(!isset($_POST['key']) || empty($_POST['key'])){
		// No parameter key is set so nothing happens
		exit("...");
	} else {
		$key = $_POST['key'];
	}


	// Check for current user role
	if($_SESSION['role'] != "student"){
		exit("Error, that is reserved to students only.");
	}


	require_once '../models/People_Functions.php';
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$community_func = new People_Functions($account_id);


	if( isset($_POST['mentor_id']) && !empty($_POST['mentor_id']) ){
		$community_func->setMentorId($_POST['mentor_id']);
	} else {
		exit("Error, Some parameter is missing..");
	}


	switch ($key) {

		case 'like_mentor':

			exit($community_func->likeMentor());

		case 'unlike_mentor':

			exit($community_func->unlikeMentor());

	}

?>