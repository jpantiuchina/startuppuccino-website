<?php
	
	require_once '../app/models/session.php';

	if ($userLogged){
		header('Location: ../');
		exit;
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../app/assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
		<title>Startuppuccino - Register</title>
	</head>
	<body>

		<?php

			include '../app/views/header.php';

			
			if (isset($_POST['submit'])){

				include '../app/controllers/register.php';

			} else {

				include '../app/views/register_form.php';

			}

			include '../app/views/footer.php';

		?>

	</body>
</html>
