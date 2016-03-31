<?php include '../assets/php/session.php'; ?>

<?php if($userLogged) header('Location: ../') ?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<title>Startuppuccino - Signup</title>
	</head>
	<body>

		<?php

			include '../assets/php/header.php';


			// evaluate data if for has been submited else show the form

			// Set variable to switch between signup success
			$signupOk = true;

			if (isset($_POST['submit'])){

				// Hash password
				$password = md5($_POST['password']);
				// Save email on variable to doublechek if it exsits (see below)
				$account_email = $_POST['email'];

				// Connect to db
				include '../assets/php/db_connect.php';

				// Validate required field (server check to avoid client injections)

				if ($_POST['password'] != ""){

					if ($_POST['email'] != ""){

						if($_POST['firstname'] != ""){

							if ($_POST['lastname'] != ""){

								if($_POST['background'] != ""){

									if($_POST['role'] == ""){

										$signupOk = false;
										$error_message = "Role field cannot be empty";

									}

								} else {

									$signupOk = false;
									$error_message = "Background field cannot be empty";

								}

							} else {

								$signupOk = false;
								$error_message = "Email field cannot be empty";
							
							}


						} else {

							$signupOk = false;
							$error_message = "Firstname field cannot be empty";
						
						}

					} else {

						$signupOk = false;
						$error_message = "Email field cannot be empty";
					
					}

				} else {
					
					$signupOk = false;
					$error_message = "Passowrd field cannot be empty";
				
				}

				// Check if there was any input error
				if($signupOk){

					$sql = "INSERT INTO Account (background, email, firstname, lastname, password, role, created, avatar, about )
							VALUES ('" . $_POST['background'] . "',
									'" . $account_email . "',
									'" . $_POST['firstname'] . "',
									'" . $_POST['lastname'] . "',
									'" . $password . "',
									'" . $_POST['role'] . "',
									'" . date("Y-m-d H:i:s") . "',
									'" . $avatar . "',
									'" . $_POST['about'] . "' )";


					// Doublecheck if email already exists
					include '../assets/php/check_email.php';
					// Resturn $emailAvailable = false if the email already exists

					if($emailAvailable){
						// Execute query and evaluate result
						if (mysqli_query($dbconn, $sql)) {
						    
						    echo "New account created successfully";

						    // Include the login script
						    $new_account_email = $account_email;
						    $new_account_password = $password; 

						    include '../login/login.php';

						    // javascript (client) redirect to home page once the user is logged
						    if ($loginOk)
					    		echo "<script>window.location='../'</script>";

						} else {

							// DB responded with error status

							// Set switch to show error message
							$signupOk = false;
							$error_message = "We had some problem creating your account, try again and if the problem persist <a href='mailto:info@minetoolz.com'>contact us</a>";

							// Include the form
							include 'signup_form.php';

						}

					} else {

						// Email already exists

						// Include the form
						include 'signup_form.php';

					}

					mysqli_close($dbconn);

				} else {

					// There was some inputs error

					// Include the form, error message was set above
					include 'signup_form.php';

				}
				

			} else {

				include 'signup_form.php';

			}


			include '../assets/php/footer.php';

		?>

	</body>
</html>
