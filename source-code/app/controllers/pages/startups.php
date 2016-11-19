<?php
	
    $CONTROLLERS_DIR = dirname( __DIR__ );
    $APP_DIR = dirname( $CONTROLLERS_DIR );


	require_once $CONTROLLERS_DIR . '/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}


	// Include and Initialize Startup Projects Functions
	require_once $APP_DIR . '/models/StartupProject_Functions.php';
	$startups_func = new StartupProject_Functions($_SESSION['id']);

	$ideas = [];

	$currentPage = "startups";
	$page_title = "Startups - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "app/assets/css/people.css"
					],
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "app/assets/css/ideas.css"
					]
				];
	$footer_scripts = ["app/assets/js/people.js", 
	                   "app/assets/js/manage_project_chooser.js",
	                   "app/assets/js/player.js",
	                   "app/assets/js/project_settings.js"];


	/* 
	 * If isset the get parameter 'project_id' ( ../index.php?user_id=xxxx )
	 * then the user details are diplayed instead of the list of users and mentors 
	 */
	$project = null;
	$isMyTeam = false;
	
	if (isset($_GET['project_id'])){

		$footer_scripts[] = "https://cdn.plyr.io/2.0.7/plyr.js";
		$metatags[] = [
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "https://cdn.plyr.io/2.0.7/plyr.css"
					  ];


		// Set the project_id of the project to show
		$startups_func->setProject($_GET['project_id']);

		$project = $startups_func->getProjectInfo();
		$isMyTeam = $startups_func->isMyTeam();
		$learning_stages = $startups_func->getLearningStages();

	}



	require_once $APP_DIR . '/models/People_Functions.php';
	$people_func = new People_Functions($_SESSION['id']);
	$residence_mentors = $people_func->getResidenceMentors();


    // Include header and footer controllers
    include 'page__init.php';

	// Set template name and variables
	
	$template_file = "startups.twig";

	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['footer_scripts'] = $footer_scripts;
	$template_variables['rel_path'] = '..';
	$template_variables['residence_mentors'] = $residence_mentors;
	
	// Prevent to load all the users data if only one profile is required
	if($project !== null){
		$template_variables['project'] = $project;
		$template_variables['is_my_team'] = $isMyTeam;
		if(isset($_GET['settings'])){
			$template_variables['settings_mode'] = true;
		}
		$template_variables['learning_stages'] = $learning_stages;
	} else {
		$projects = $startups_func->getAllProjects();
		shuffle($projects);
		$template_variables['projects'] = $projects;
	}

    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);


?>