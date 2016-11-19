<?php
    
    $CONTROLLERS_DIR = dirname( __DIR__ );
    $APP_DIR = dirname( $CONTROLLERS_DIR );


	require_once $CONTROLLERS_DIR . '/session.php';

	// Redirect to home if user is not logged
	/*if(!$userLogged || $_SESSION['role']!='educator'){
		header("Location: ../");
		exit;
	}*/


	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	
	// Include and Initialize StartupProject Functions
	require_once $APP_DIR . '/models/StartupProject_Functions.php';
	$project_func = new StartupProject_Functions($account_id);

	
	$currentPage = "lollipop";
	$page_title = "Lollipop - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "app/assets/css/ideas.css"
					]
				];


    // Include header and footer controllers
    include 'page__init.php';


	// Set template name and variables
	
	$template_file = "lollipop.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['rel_path'] = '..';

	$template_variables['project_mentor_matches'] = $project_func->getProjectMentorMatches();

    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);


?>