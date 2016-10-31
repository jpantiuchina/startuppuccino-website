<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}
	

	// Include and Initialize Ideas Functions
	require_once '../app/models/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($account_id);

	$ideas = [];

	$currentPage = "ideas";
	$page_title = "Ideas - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/ideas.css"
					]
				];
	$footer_scripts = ["../app/assets/js/ideas.js"];
	$view = null;
	$user_can_join = count($ideas_func->user_joins) < 1;


	if ( !($ideas = $ideas_func->getAllIdeas()) && $_SESSION['ideas_phase'] != "1" ){
		
		// Do nothing ... ideas is empty array

	} else {

		shuffle($ideas);
		// Include the view switch to include the right block according to idea phase
		include '../app/controllers/ideas__view_switch.php';

	}


	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "ideas.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['footer_scripts'] = $footer_scripts;
	$template_variables['rel_path'] = '..';
	$template_variables['user_can_join'] = $user_can_join;
	if($_SESSION['ideas_phase'] == "3"){
		$template_variables['joined_idea'] = $ideas_func->getJoinedIdea();
	}

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>