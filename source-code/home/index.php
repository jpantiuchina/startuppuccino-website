<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home - Startuppuccino</title>
	<link rel="stylesheet" type="text/css" href="../app/assets/newcss/home.css">
</head>
<body>

	<?php $page_title = 'Lectures'; ?>

	<?php include '../app/views/header_new.php'; ?>

	<main>

		<?php include '../app/controllers/course_sessions.php'; ?>

	</main>

	<?php include '../app/views/footer.php'; ?>

	<script src="../app/assets/js/home.js"></script>

</body>
</html>