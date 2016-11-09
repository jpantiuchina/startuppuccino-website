<?php
    
    //exit("Do you want some cake?");

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	/*if(!$userLogged || $_SESSION['role']!='educator'){
		header("Location: ../");
		exit;
	}*/


	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	
	// Include and Initialize StartupProject Functions
	require_once '../app/models/StartupProject_Functions.php';
	$project_func = new StartupProject_Functions($account_id);

	
	$currentPage = "lollipop";
	$page_title = "Lollipop - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/ideas.css"
					]
				];


	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "lollipop.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['rel_path'] = '..';

	$template_variables['project_mentor_matches'] = $project_func->getProjectMentorMatches();

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>