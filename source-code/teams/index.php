<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged) {
		header("Location: ../");
		exit;
	}
	
?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../app/assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/team.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/listview.css">
		<title>Startuppuccino - Teams</title>

	</head>
	<body>
		
		<?php $page_title = "Teams"; ?>

		<?php include '../app/views/header.php'; ?>


		<?php

			/* If isset the get parameter 'team_id' ( ../index.php?team_id=xxxx )
			links like ../teams/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			then the team details are diplayed instead of the list of teams */

			if(isset($_GET['team_id'])){

				// Show one team details
				include '../app/controllers/team.php';

			} else {

				// Show all teams
				include '../app/controllers/team_list.php';

			} // endif switch all users list or single user details

			?>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>