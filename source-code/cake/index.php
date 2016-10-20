<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}


	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	
	// Include and Initialize Ideas Functions
	require_once '../app/models/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($account_id);

	
	$currentPage = "cake";
	$page_title = "Cake - Ranklist - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/ideas.css"
					]
				];

	$ranklist = $ideas_func->getIdeaRanklist();

	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "cake.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['rel_path'] = '..';
	$template_variables['ranklist'] = $ranklist;

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>