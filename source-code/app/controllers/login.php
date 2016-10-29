<?php
	
	require_once '../app/models/session.php';

	require_once '../app/models/Credential_Functions.php';
	$credential_func = new Credential_Functions();

	$credential_func->setEmail($login_email);
	$credential_func->setPassword($login_password);
	$account_data = $credential_func->login();


	// Set defalut values of email
	$login_data = ['email' => $login_email, 'password' => $login_password];


	/* default global variable to switch and redirect if login is successful 
	   or show error message on login_form
	 */
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

	   	// Check if a persistent login has been required
	   	if( isset($isPermaLogin) &&
	   		$isPermaLogin === TRUE && 
	   		!empty( $cookie_token = $credential_func->setPermaLogin($_SESSION['id']) ) ){
	   		$days = 90;
	   		setcookie("permalog", $cookie_token, time() + (86400 * $days), "/");
	   	}

	   	// Redirect to home page
	   	header("Location: ../");
	   	// Client redirect if header fails
	   	echo "<script>window.location='../'</script>";

	}

?>