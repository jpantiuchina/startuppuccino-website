<?php

	require '../assets/php/session.php';

	require '../assets/php/db_connect.php';

	// Redirect to home if user is not logged
	if(!$userLogged) header("Location: ../");

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<title>Startuppuccino - Edit Team</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

		<?php 

			// Read the team id parameters (through post or get)
			// Die if no team_id is set
			$team_id = "";
			if(isset($_POST['team_id'])) $team_id = $_POST['team_id'];
			else if(isset($_GET['team_id'])) $team_id = $_GET['team_id'];
			if($team_id == "") die("Some parameters were missing.");

			// If the team_id is set initialize the Team Functions
			require_once '../assets/php/Team_Functions.php';
			$team_func = new Team_Functions($_SESSION['id'],$team_id);

			// Check if the user is a team member
			// and get the current team info
			if($team_data = $team_func->userIsMember()){

				// Check if post data have been submited to be store
				if(isset($_POST['submit_team'])) {

					// Check if there are all the required parameters
					$name = "";
					if(isset($_POST['name'])) $name = $_POST['name'];
					if($name == "") die("Some parameters were missing.");

					// Update team info
					// Override the team_data array with the updated current info
					if(!$team_data = $team_func->updateTeam($name)) {

						echo "Something went wrong, maybe this is the wrong team!";

					}	

				} else if(isset($_POST['submit_quit_team'])) {

					// Quit the team
								
					// The account should be put in a "waiting list" and be approved by an educator
					// Otherwise uncomment the code below to let user automatically leave teams
					// ATTENTION: there is no feature that let user join a team once the team is created.

					echo "At the moment you cannot leave a team, please contact an admin or your teacher to do this.";

					/*

					// Delete record in the TeamAccount
					
					$query = "DELETE FROM TeamAccount WHERE account_id='".$_SESSION['id']."'";
				
					if($result = mysqli_query($dbconn,$query)){

						if(mysqli_affected_rows($dbconn)==1){

							?>

								<h5>You are no more member of this team.</h5>
								<a href="../ideas/">Back to ideas</a>

							<?php

						} else if(mysqli_affected_rows($dbconn)<1){

							echo "Something went wrong, please try again.";

						} else {

							echo "These data are equals to the current data, you do not needed to do this ;)";
							?> <a href="../ideas/">Back to ideas</a> <?php

						}

					} else {

						echo "Something went wrong while deleting you from the team.";

					} 

					*/

				} else {

					// No post data have been detect
					// We just show the team form
				
				}

				// Now show the team form
				require 'team_form.php';

			} else {

				echo "Something went wrong, maybe this is the wrong team!";

			}

		?>


		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>