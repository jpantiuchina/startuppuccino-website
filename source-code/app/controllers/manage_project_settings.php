<?php
	
	require_once '../models/session.php';

	function cleanText($text){
		return str_replace("'", " ", $text);
	}

	if(!isset($_POST['project_id']) || empty($_POST['project_id']) ||
	   !isset($_POST['name']) || empty($_POST['name']) ||
	   !isset($_POST['id']) || empty($_POST['id']) ||
	   !isset($_POST['value'])){
		// No parameter name is set so nothing happens
		exit("...");
	} else {
		$name = $_POST['name'];
		$value = $_POST['value'];
		$project_id = $_POST['project_id'];
	}

	
	require_once '../models/StartupProject_Functions.php';
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$project_func = new StartupProject_Functions($account_id);

	$project_func->setProject($project_id);

	if(!$project_func->isMyTeam()){
		exit("Sorry this is not your team.");
	}

	switch($name){

		case 'title':

			exit($project_func->setTitle(cleanText($value)));

		case 'description':

			exit($project_func->setDescription(cleanText($value)));

		case 'milestone_2':

			exit($project_func->setMilestone2(cleanText($value)));

	}

?>