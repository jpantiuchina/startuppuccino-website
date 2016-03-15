<?php
	
	if(isset($_GET['email'])){
		$account_email = $_GET['email'];
	}

	if(!$dbconn){
		include 'db_connect.php';
	}

	$check_mail_query = mysqli_query($dbconn, "SELECT id, firstname FROM Account WHERE email='" . $account_email . "'");

	// Check if email already exists
	if ($check_mail_query){

		if (mysqli_num_rows($check_mail_query) > 0) {
			echo "Email already exists";
		} else {
			echo "Ok";
		}

	}

?>