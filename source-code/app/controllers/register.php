<?php
	
	require_once '../app/models/session.php';

	// Set empty error_message
	$error_message = "";

	$isRegister = false;
	
	require_once '../app/models/Credential_Functions.php';
	$credential_func = new Credential_Functions();

	// Validate inputs
	// Return string with error message if validation fails
	$inputs_validation = $credential_func->validateInputs(md5($_POST['password']),md5($_POST['password1']),$_POST['email'],$_POST['firstname'],$_POST['lastname'],$_POST['background'],$_POST['role'],$_POST['skills']);

	// Check if email already exists
	$email_exists = $credential_func->emailExists();

	if($inputs_validation===true){

		if(!$email_exists){

			// Execute query and evaluate result
			if ($credential_func->register()) {

				$isRegister = true;
			    
			    // Send "Welcome email"
			    // ...

				// Login
				$login_email = $_POST['email'];
				$login_password = md5($_POST['password']);
				include '../app/controllers/login.php';

			} else {

				// DB answered with error status
				$error_message = "We had some problem creating your account, try again and if the problem persist <a href='mailto:info@minetoolz.com'>contact us</a>";

			}

		} else {

			$error_message = "Email already exists";

		}

	} else {

		$error_message = $inputs_validation;

	}

	if(!$isRegister){
		include '../app/views/register_form.php';
	}

?>