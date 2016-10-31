<?php 

	require_once '../app/models/session.php';

	// Include and Initialize Account Functions
	require_once '../app/models/Account_Functions.php';
	$account_func = new Account_Functions($_SESSION['id']);

	
	if ( isset($_POST['update_account_info']) ){

		// if submit of account info is set evaluate it and update the account info

		// Check if there is some required field with empty value
		if ( empty($_POST['email']) ||
			 empty($_POST['firstname']) ||
			 empty($_POST['lastname']) ||
			 empty($_POST['background']) ||
			 empty($_POST['skills']) || count(explode(",", $_POST['skills']))<1 ){

			$general_alert = "You are trying to save a required field with empty value... why?!";

		} else if ( $_POST['email'] === $_SESSION['email'] &&
					$_POST['firstname'] === $_SESSION['firstname'] &&
					$_POST['lastname'] === $_SESSION['lastname'] &&
					$_POST['background'] === $_SESSION['background'] &&
					$_POST['skills'] === $_SESSION['skills'] && 
					$_POST['about'] === $_SESSION['about'] ) {

			// Do nothing ... data are the same already saved

		} else {

			if ($account_func->updateAccount( $_POST['email'],
											  $_POST['firstname'],
											  $_POST['lastname'],
											  $_POST['background'],
											  $_POST['skills'],
											  $_POST['about']) ){

				// Update session data
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['firstname'] = $_POST['firstname'];
				$_SESSION['lastname'] = $_POST['lastname'];
				$_SESSION['background'] = $_POST['background'];
				$_SESSION['skills'] = $_POST['skills'];
				$_SESSION['about'] = $_POST['about'];

				$general_alert = "Data saved";

			} else {
				
				$general_alert = "Something went wrong<br><br><a href=''>Reload the page</a>";
			
			}

		}


	} else if ( isset($_POST['update_password']) ){

		// if submit of password is set evaluate it and save the new password

		// check if the password are the not the same and new password is not empty
		if ( $_POST['old_password'] == $_POST['new_password'] ){

			$general_alert = "Old and new password are the same :o";

		} else if ( empty($_POST['new_password']) ){

			$general_alert = "Come on! A password must have at least one char";

		} else {

			if ( $account_func->updatePassword($_POST['old_password'], $_POST['new_password']) ){

				$general_alert = "Password successfully updated";
			
			} else {
			
				$general_alert = "Password not updated.";
			
			}
		
		}

	} 



	// Get current account info and show the form
    if ($account = $account_func->readAccountData()) {

    	// Print out the account form
    	require '../app/views/account_form.php';

	} else {

	    echo "Something went wrong.. please <a href='../logout/'>logout</a> and login again.";
	
	}

?>