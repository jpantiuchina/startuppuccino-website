<?php
	
	require_once '../models/session.php';
	
	if(!isset($_POST['key']) || empty($_POST['key'])){
		// No parameter key is set so nothing happens
		exit("...");
	} else {
		$key = $_POST['key'];
	}

	// Include and Initialize People Functions
	require_once '../models/Ideas_Functions.php';
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$ideas_func = new Ideas_Functions($account_id);

	// Set the current idea
	$idea_id = isset($_POST['idea_id']) ? $_POST['idea_id'] : null;
	$ideas_func->setIdea($idea_id);

	// TODO: add check for current user role

	// Check current ideas phase
	$phase1 = ["new_idea","delete_idea","edit_idea","get_comments","new_comment","delete_comment"];
	$phase2 = ["like_idea","unlike_idea"];
	$phase3 = ["join_idea","leave_idea"];
	if(($_SESSION['ideas_phase']==1 && !in_array($key, $phase1)) ||
	   ($_SESSION['ideas_phase']==2 && !in_array($key, $phase2)) ||
	   ($_SESSION['ideas_phase']==3 && !in_array($key, $phase3))){
		exit("Error, you do not have the access to this functionality.");
	}

	switch ($key) {

		case 'join_idea':

			exit($ideas_func->joinIdea());
			
		case 'leave_idea':
		
			exit($ideas_func->leaveIdea());
		
		case 'new_idea':

			exit($response = $ideas_func->newIdea($_POST['title'],
											//$_POST['team_size'],
											$_POST['description'],
											$_POST['avatar'],
											$_POST['background_pref']));
			
		case 'teamsize':
		
			exit($ideas_func->getTeamsize());
		
		case 'delete_idea':
			
			exit($ideas_func->deleteIdea());

		case 'edit_idea':

			//exit("Not yet implemented");
			exit($ideas_func->editIdea($_POST['title'],
										//$_POST['team_size'],
										$_POST['description'],
										$_POST['avatar'],
										$_POST['background_pref']));

		case 'get_comments':

			exit(implode("<br>", $ideas_func->getComments()));

		case 'new_comment':

			exit($ideas_func->newComment($_POST['comment']));

		case 'delete_comment':

			exit($ideas_func->deleteComment($_POST['comment_id']));

		case 'like_idea':

			exit($ideas_func->like());

		case 'unlike_idea':

			exit($ideas_func->unlike());

	}

?>