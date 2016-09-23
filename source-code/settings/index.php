<?php

	require_once '../app/models/session.php';

	if(!$userLogged) {
		header('Location: ../');
		exit;
	}
	
?>

<!DOCTYPE html>
<html>
	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/settings.css">
		<title>Account Settings - Startuppuccino</title>
	
	</head>
	<body>
		
		<?php include '../app/views/header_new.php'; ?>

		<main>

			<?php require '../app/controllers/account_settings.php'; ?>

		</main>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>