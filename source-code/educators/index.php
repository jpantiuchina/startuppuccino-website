<?php
	
	require_once '../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../");
		exit;
	}

?>


<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
		<title>Manager - Startuppuccino</title>

		<style type="text/css">
		.box{position:relative; margin: 20px;padding: 15px;font-weight: bold;background-color: #333;}
		.box:hover{background-color: #777}
		.box > a {text-decoration: none;color:#fff;display: block;height: 100%}

		.box.parent{background-color: #999 !important}
		</style>

	</head>
	<body>


		<div class="box"><a href="../"><- Back</a></div>


		<div class="box parent"><a href="./manage/">Manage</a></div>	

		<div class="box"><a href="./manage/sessions/">Edit Sessions</a></div>
		<div class="box"><a href="./manage/ideas/idea_phase.php">Change ideas phase</a></div>
		<div class="box"><a href="./manage/ideas/idea_approve.php">Approve ideas</a></div>
		<div class="box"><a href="./manage/ideas/idea_to_team.php">Ideas to teams</a></div>		
		<div class="box"><a href="./manage/mail/">Send mail to mentors</a></div>


		<div class="box parent"><a href="./analytics/">Analytics</a></div>	

		<div class="box"><a href="./analytics/people/">People analytics</a></div>

	</body>
</html>