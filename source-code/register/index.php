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
	
		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/register.css">
		<title>Startuppuccino - Register</title>
	
		
        <?php include '../app/views/extra_head_html.php'; ?>

	
	</head>
	<body>

		<?php $page_title="Register"?>

		<?php $currentPage = 'register' ?>
		<?php include '../app/views/header_new.php'; ?>

		<main>

			<h1>Registration</h1>


			<?php 
				if (isset($_POST['submit'])){

					include '../app/controllers/register.php';

				} else {

					include '../app/views/register_form.php';

				}
			?>

		</main>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>
