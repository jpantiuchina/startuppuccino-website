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
	<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
</head>
<body>

	<?php include '../app/views/header.php'; ?>

	<h1>Let's take a coffee then...</h1>

	<?php include '../app/views/footer.php'; ?>

</body>
</html>