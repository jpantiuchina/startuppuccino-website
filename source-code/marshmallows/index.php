<?php
    
    //exit("Do you want some cake?");

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged || $_SESSION['role']!='educator'){
		header("Location: ../");
		exit;
	}


	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	
	// Include and Initialize StartupProject Functions
	require_once '../app/models/StartupProjec_Functions.php';
	$project_func = new StartupProject_Functions($account_id);
	// Include and Initialize People Functions
	require_once '../app/models/People_Functions.php';
	$community_func = new People_Functions($account_id);

	
	$currentPage = "marshmallows";
	$page_title = "Marshmallows - Startuppuccino";
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
	
	$template_file = "marshmallows.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['rel_path'] = '..';

	$template_variables['mentor_choices'] = $project_func->getMentorProjectChoices();
	$template_variables['project_choices'] = $community_func->getProjectMentorChoices();

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>