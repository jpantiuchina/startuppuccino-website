<?php
	
	require_once '../models/session.php';

	function cleanText($text){
		return str_replace("'", " ", $text);
	}

	if(!isset($_POST['key']) || empty($_POST['key'])){
		// No parameter key is set so nothing happens
		exit("...");
	} else {
		$key = $_POST['key'];
	}

	
	require_once '../models/StartupProject_Functions.php';
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$project_func = new StartupProject_Functions($account_id);

	
	if( isset($_POST['project_id']) && !empty($_POST['project_id']) ){
		$project_func->setProject($_POST['project_id']);
	} else {
		exit("Error, Some parameter is missing..");
	}


	switch ($key) {

		case 'like_project':

			exit($project_func->likeMentor());

		case 'unlike_project':

			exit($project_func->unlikeMentor());

	}

?>