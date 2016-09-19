<?php
	
	require_once '../app/models/session.php';

	require_once '../app/models/Credential_Functions.php';
	$credential_func = new Credential_Functions();

	$credential_func->setEmail($login_email);
	$credential_func->setPassword($login_password);
	$account_data = $credential_func->login();

	// default global variable to switch and redirect if login is successful or show error message on login_form
	$loginOk = (count($account_data) > 0);

	if($loginOk) {

		// Set session data
		foreach ($account_data as $key => $value) {
			$_SESSION[$key] = $value;
		}

		// Load Config
	   	require_once '../app/models/Config_Functions.php';
	   	$config_func = new Config_Functions();
	   	// Load ideas settings
	   	$config_func->load();

	   	// If is a mentor we load the sessions availability
	   	if($_SESSION['role'] === "mentor"){
	   		require_once '../app/models/CourseSessions_Functions.php';
			$cs_func = new CourseSessions_Functions();
			$_SESSION['lectures_availability'] = $cs_func->getMentorSessionAvailability($_SESSION['id']);
	   	}

	   	// Redirect to home page
    	header("Location: ../");

	} else {

		include '../app/views/login_form.php';

	}

?>