<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}


	// Include and Initialize People Functions
	require_once '../app/models/People_Functions.php';
	$people_func = new People_Functions($_SESSION['id']);

	$ideas = [];

	$currentPage = "community";
	$page_title = "Community - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/people.css"
					]
				];
	$footer_scripts = ["../app/assets/js/people.js"];


	/* 
	 * If isset the get parameter 'user_id' ( ../index.php?user_id=xxxx )
	 * then the user details are diplayed instead of the list of users and mentors 
	 */
	$isnotset_user = false;
	if (isset($_GET['user_id'])){

		// Set the account_id of the person to show
		$people_func->setPerson($_GET['user_id']);

		if ($user = $people_func->getPersonInfo()){

			include '../app/controllers/community__profile.php';

		} else {
	
			$isnotset_user = true;

		}

	}


	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "community.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['footer_scripts'] = $footer_scripts;
	$template_variables['rel_path'] = '..';
	
	// Prevent to load all the users data if only one profile is required
	if($isnotset_user){
		$template_variables['user'] = '404';
	} else {
		$template_variables['users'] = $people_func->getAllPeople();
	}

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>