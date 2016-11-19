<?php
	
	require_once '../models/session.php';

	function cleanText($text){
		return str_replace("'", " ", $text);
	}

	if(!isset($_POST['key']) || empty($_POST['key']) ||
	   !isset($_POST['project_id']) || empty($_POST['project_id'])){
		
		exit("...");
	
	} else {
	
		$key = $_POST['key'];
		$project_id = cleanText($_POST['project_id']);

	}

	
	require_once '../models/StartupProject_Functions.php';
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$project_func = new StartupProject_Functions($account_id);

	$project_func->setProject($project_id);

	switch($key){

		case 'new_learningstage':

			if(!$project_func->isMyTeam()){
				exit("Sorry this is not your team.");
			}

			if ( !isset($_POST['title']) || empty($_POST['title']) ||
			     !isset($_POST['description']) || empty($_POST['description']) ||
			     !isset($_POST['mood']) || empty($_POST['mood']) ) {

				exit("Some parameter is missing..");
			
			} else {

				$description = cleanText($_POST['description']);
				$mood = cleanText($_POST['mood']);
				$title = cleanText($_POST['title']);

			}

			exit($project_func->newLearningStage($title, $description, $mood));

		case 'get_learningstages':

			$template_variables['learning_stages'] = $project_func->getLearningStages();
			$template_variables['sess'] = $_SESSION;
			$template_file = "startups__project_chart_stages.twig";

		    // Render the template
		    require_once '../views/_Twig_Loader.php';
		    exit( (new Twig_Loader())->render($template_file, $template_variables) );

		case 'set_learningstage_status':

			if (!$project_func->isTheMentor()) {
				exit("You are not the mentor of this team.");
			}

			if ( !isset($_POST['status']) || !isset($_POST['stage_id']) ) {
				exit("New stage status not defined");
			} else if ( $_SESSION['role'] != "mentor" ){
				exit("You don't have the rights to do this.");
			} else {
				$status = cleanText($_POST['status']);
				$stage_id = cleanText($_POST['stage_id']);
			}

			exit($project_func->setLearningstageStatus($status, $stage_id));

	}

	exit("Error...");

?>