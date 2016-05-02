<?php

	require '../assets/php/session.php';

	require '../assets/php/db_connect.php';

	if(!$userLogged) die("What are you doning here? :(");

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<title>Account - Startuppuccino</title>
	
	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

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

					$update_query = mysqli_query($dbconn, "UPDATE Account SET
															email='".$_POST['email']."',
															firstname='".$_POST['firstname']."',
															lastname='".$_POST['lastname']."',
															background='".$_POST['background']."',
															role='".$_POST['role']."',
															about='".$_POST['about']."' 
															WHERE id='".$_SESSION['id']."'");

					if ($update_query){

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

				// check if the password are the not the same
				if ($_POST['old_password'] == $_POST['new_password']){

					echo "Old and new password are the same :o";

				} else if ($_POST['new_password'] == ""){

					echo "Come on! A password must have at least one char";

				} else {

					$update_query = mysqli_query($dbconn, "UPDATE Account SET password='".md5($_POST['new_password'])."' WHERE id='".$_SESSION['id']."' AND password='".md5($_POST['old_password'])."'");

					if ($update_query){

						echo "Password successfully updated<br><br><a href=''>Back to account settings</a>";
					
					} else {
					
						echo "Something went wrong<br><br><a href=''>Reload the page</a>";
					
					}
				
				}

			} else {

				// No submit is set, so the form to update the account info is shown

				$profile_view = mysqli_query($dbconn, "SELECT about, avatar, background, email, firstname, lastname, role FROM Account WHERE id='" . $_SESSION['id'] . "' ");


				if (mysqli_num_rows($profile_view) == 1) {

				    while($account = mysqli_fetch_assoc($profile_view)) {

				    	?>

						<form action="" method="post">

							<label>Email</label>
							<input type="email" name="email" value="<?php print $account['email']; ?>" required/>

							<label>Firstname</label>
							<input type="text" name="firstname" value="<?php print $account['firstname'];?>" required/>

							<label>Lastname</label>
							<input type="text" name="lastname" value="<?php print $account['lastname'];?>" required/>

							<label>Background</label>
							<input type="text" name="background" placeholder="e.g. IT, design, law, economics, management" value="<?php print $account['background'];?>" required/>

							<label>About me (optional)</label>
							<textarea name="about" placeholder="More info about me, about my startup idea, etc."><?php print $account['about'];?></textarea>

							<label>Role</label>
							<label>
								<input type="radio" name="role" value="student" <?php if ($account['role'] == "student") print "checked=\"checked\"";?> required/>Student (I'm here to learn)
							</label>
							<label>
								<input type="radio" name="role" value="mentor" <?php if ($account['role'] == "mentor") print "checked=\"checked\"";?> required/>Mentor (I'm here to help)
							</label>

							<input type="submit" name="update_account_info" value="SAVE" />
							
						</form>

						<hr>

						<form action="" method="post">

							<h4>Change Password</h4>
							
							<label>Old Password</label>
							<input type="password" name="old_password" required/>
							
							<label>New Password</label>
							<input type="password" name="new_password" required/>
							
							<input type="submit" name="update_password" value="SAVE" />

							<!-- TODO -> add javascript check on submit to verify that the two password are not equals -->

						</form>

						<!-- 
							TODO -> Add form to upload profile picture
							hint: use the iframe and with a javascript callback
								  in order to make the upload async
						-->

				        <?php
				    }

				} else {

				    echo "Something went wrong.. please <a hreg='../logout/'>logout</a> and login again.";
				
				}

			}

			mysqli_close($dbconn);

		?>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>

