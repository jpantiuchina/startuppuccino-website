<?php
	
	$emailAvailable = false;

	if(isset($_GET['email'])){
		$account_email = $_GET['email'];
	}

	if($account_email != ""){

		if(!$dbconn){
			require 'db_connect.php';
		}

		$check_mail_query = mysqli_query($dbconn, "SELECT id, firstname FROM "._T_ACCOUNT." WHERE email='" . $account_email . "'");

		// Check if email already exists
		if ($check_mail_query){

			if (mysqli_num_rows($check_mail_query) > 0) {
			
				$error_message = "Email already exists";
			
			} else {
				
				// Ok.. the email is available
				$emailAvailable = true;
			
			}

		}

	} else {

		// prevent to access the database if no email is set
		echo ":)";

	}

?>