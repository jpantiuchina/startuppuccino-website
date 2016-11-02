<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}


	// Include and Initialize Startup Projects Functions
	require_once '../app/models/StartupProject_Functions.php';
	$startups_func = new StartupProject_Functions($_SESSION['id']);

	$ideas = [];

	$currentPage = "startups";
	$page_title = "Startups - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/people.css"
					],
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/ideas.css"
					]
				];
	$footer_scripts = ["../app/assets/js/people.js", "../app/assets/js/manage_project_chooser.js"];


	/* 
	 * If isset the get parameter 'project_id' ( ../index.php?user_id=xxxx )
	 * then the user details are diplayed instead of the list of users and mentors 
	 */
	$project = null;
	$isMyTeam = false;
	
	if (isset($_GET['project_id'])){

		// Set the project_id of the project to show
		$startups_func->setProject($_GET['project_id']);

		$project = $startups_func->getProjectInfo();
		$isMyTeam = $startups_func->isMyTeam();

	}


	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "startups.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['footer_scripts'] = $footer_scripts;
	$template_variables['rel_path'] = '..';
	
	// Prevent to load all the users data if only one profile is required
	if($project !== null){
		$template_variables['project'] = $project;
		$template_variables['is_my_team'] = $isMyTeam;
		if(isset($_GET['settings'])){
			$template_variables['settings_mode'] = true;
		}
	} else {
		$projects = $startups_func->getAllProjects();
		shuffle($projects);
		$template_variables['projects'] = $projects;
	}

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>