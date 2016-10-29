<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is already logged
	if($userLogged){
		header("Location: ../");
		exit;
	}
	
	$currentPage = "login";
	$page_title = "Login - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/login.css"
					]
				];

	$login_data = ["email"=>"","password"=>""];

	if (isset($_POST['login'])){

 		$login_email = $_POST['email'];
 		$login_password = md5($_POST['password']);

 		$isPermaLogin = isset($_POST['permalogin']) && $_POST['permalogin'] === "y";

 		include '../app/controllers/login.php';
		
	} else {

		// initialize variable to prevent to show the error message
		$loginOk = true;
		
	}


	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "login.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['rel_path'] = '..';

	$template_variables['loginOk'] = $loginOk;
	$template_variables['login_data'] = $login_data;

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>