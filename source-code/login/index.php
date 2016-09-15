<?php 

	require_once '../app/models/session.php'; 

	if ($userLogged) {
		header('Location: ../');
		exit;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		
		<title>Startuppuccino - Login</title>
		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/login.css">

	</head>
	<body>

		<?php include '../app/views/header_new.php'; ?>

		<main>

			<?php

			 	if (isset($_POST['login'])){ 

			 		$login_email = $_POST['email'];
			 		$login_password = md5($_POST['password']);

			 		include '../app/controllers/login.php';
					
				} else {

					// initialize variable to prevent to show the error message
					$loginOk = true;
					
					include '../app/views/login_form.php';

				}
			
			?>

		</main>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>