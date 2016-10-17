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
	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/register2.css">
		<title>Startuppuccino - Register</title>
	
	</head>
	<body>

		<?php $page_title = "Register"; ?>

		<?php include '../app/views/header.php'; ?>

		<main>

			<?php 
				if (isset($_POST['submit'])){

					include '../app/controllers/register.php';

				} else {

					include '../app/views/register_form2.php';

				}
			?>

		</main>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>
