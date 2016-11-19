<?php

    $CONTROLLERS_DIR = dirname( __DIR__ );
    $APP_DIR = dirname( $CONTROLLERS_DIR );


	require_once $CONTROLLERS_DIR . '/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}
	
	$currentPage = "player";
	$page_title = "Media Player - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "app/assets/newcss/player.css"
					],
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "https://cdn.plyr.io/2.0.7/plyr.css"
					]
				];
	$footer_scripts = ["https://cdn.plyr.io/2.0.7/plyr.js",
					   "app/assets/js/player.js"];
	$media = null;

	// Redirect to home if media file is not set
	if(isset($_GET['p']) && !empty($_GET['p']) &&
	   isset($_GET['k']) && !empty($_GET['k']) &&
	   isset($_GET['t']) && !empty($_GET['t'])){

		switch ($_GET['k']) {
			case "video":
				$path_to = "app/public/media/video/";
				break;
			
			default:
				$path_to = "";
				break;
		}

		$media = [
					"kind" => $_GET['k'],
					"type" => $_GET['t'],
					"path" => $path_to.$_GET['p']
				];

	} else {
		header("Location: ../");
		exit;
	}



    // Include header and footer controllers
    include 'page__init.php';


	// Set template name and variables
	
	$template_file = "player.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['footer_scripts'] = $footer_scripts;
	
	$template_variables['media'] = $media;

    // Render the template
    require_once $CONTROLLERS_DIR . '/Twig_Loader.php';
    Twig_Loader::show($template_file, $template_variables);


?>