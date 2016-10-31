<?php
	
	require_once '../../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../");
		exit;
	}

?>


<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../../app/assets/css/general.css">
		<title>Analytics - Startuppuccino</title>

		<style type="text/css">
		.box{position:relative; margin: 20px;padding: 15px;font-weight: bold;background-color: #333;}
		.box:hover{background-color: #777}
		.box > a {text-decoration: none;color:#fff;display: block;height: 100%}
		</style>

	</head>
	<body>

		<div class="box"><a href="../"><- Back</a></div>

		<div class="box"><a href="./people">People analytics</a></div>

	</body>
</html>