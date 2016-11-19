<?php
    
    $CONTROLLERS_DIR = dirname( __DIR__ );
    $APP_DIR = dirname( $CONTROLLERS_DIR );


	require_once $CONTROLLERS_DIR . '/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged || $_SESSION['role']!='educator'){
		header("Location: ../");
		exit;
	}


	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	
	// Include and Initialize Ideas Functions
	require_once $APP_DIR . '/models/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($account_id);

	
	$currentPage = "cake";
	$page_title = "Cake - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "app/assets/css/ideas.css"
					]
				];

	$ranklist = $ideas_func->getIdeaRanklist();


    // Include header and footer controllers
    include 'page__init.php';


	// Set template name and variables
	
	$template_file = "cake.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['rel_path'] = '..';
	$template_variables['ranklist'] = $ranklist;

    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);


?>