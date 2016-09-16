<?php

	require_once '../app/models/session.php';

	if(!$userLogged) {
		header('Location: ../');
		exit;
	}

	// Include and Initialize Account Functions
	require_once '../app/models/Account_Functions.php';
	$account_func = new Account_Functions($_SESSION['id']);
	
?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../app/assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
		<title>Account - Startuppuccino</title>
	
	</head>
	<body>
		
		<?php $page_title = "Account settings"; ?>

		<?php include '../app/views/header.php'; ?>

		<?php 

			if (isset($_POST['update_account_info'])){

				// if submit of account info is set evaluate it and update the account info

				// Check if there is some required field with empty value
				if ( $_POST['email'] == "" ||
					 $_POST['firstname'] == "" ||
					 $_POST['lastname'] == "" ||
					 $_POST['background'] == "" ||
					 $_POST['role'] == "" ){

					echo "You are trying to save a required field with empty value... why?!<br><br>Just go <a href=''>back</a> please :|";

				} else {

					if ($account_func->updateAccount($_POST['email'],$_POST['firstname'],$_POST['lastname'],$_POST['background'],$_POST['role'],$_POST['about'])){

						// Update session data
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['firstname'] = $_POST['firstname'];
						$_SESSION['lastname'] = $_POST['lastname'];
						$_SESSION['background'] = $_POST['background'];
						$_SESSION['role'] = $_POST['role'];

						echo "Account info successfully updated<br><br><a href=''>Back to account settings</a>";

					} else {
						
						echo "Something went wrong<br><br><a href=''>Reload the page</a>";
					
					}

				}


			} else if (isset($_POST['update_password'])){

				// if submit of password is set evaluate it and save the new password

				// check if the password are the not the same and new password is not empty
				if ($_POST['old_password'] == $_POST['new_password']){

					echo "Old and new password are the same :o";

				} else if ($_POST['new_password'] == ""){

					echo "Come on! A password must have at least one char";

				} else {

					if ($account_func->updatePassword($_POST['old_password'],$_POST['new_password'])){

						echo "Password successfully updated<br><br><a href=''>Back to account settings</a>";
					
					} else {
					
						echo "Something went wrong<br><br><a href=''>Reload the page</a>";
					
					}
				
				}

			} 

			// Get current account info and show the form
		    if ($account = $account_func->readAccountData()) {

		    	// Print out the account form
		    	require 'account_form.php';

			} else {

			    echo "Something went wrong.. please <a hreg='../logout/'>logout</a> and login again.";
			
			}

		?>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>