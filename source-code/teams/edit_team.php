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

			// TODO: improve code quality and avoid code repetition

			// Check if post data have been submited to be store
			if(isset($_POST['submit_team']) || isset($_POST['submit_quit_team'])){

				// Check if there are all the required parameters before continue
				if(isset($_POST['submit_team'])){
					$name = "";
					if(isset($_POST['name'])) $name = $_POST['name'];
					if($name == "") die("Some parameters were missing.");
				}
				$team_id = "";
				if(isset($_POST['team_id'])) $team_id = $_POST['team_id'];
				if($team_id == "") die("Some parameters were missing.");

				// Check if the the user is a member of the selected team
				$query = "SELECT team.id, team.name
						  FROM TeamAccount ta, Teams team
						  WHERE ta.account_id='".$_SESSION['id']."'
						  AND ta.team_id='".$team_id."'
						  AND ta.team_id=team.id";

				if($result = mysqli_query($dbconn,$query)){

					if(mysqli_num_rows($result)==1){

						// Switch if we want to change team info or quit the team
						if(isset($_POST['submit_quit_team'])){
							
							// The account should be put in a "waiting list" and be approved by an educator
							// Otherwise uncomment the code below to let user automatically leave teams
							// ATTENTION: there is no feature that let user join a team once the team is created at the moment.

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

						} else if(isset($_POST['submit_team'])){

							
							// Delete record in the TeamAccount
							$query = "UPDATE Teams SET name='".$name."' WHERE id='".$team_id."'";

							if($result = mysqli_query($dbconn,$query)){

								if(mysqli_affected_rows($dbconn)==1){

									?>

										<h5>Team Info Updated</h5>

									<?php

								} else if(mysqli_affected_rows($dbconn)<1){

									echo "Something went wrong, please try again.";

								} else {

									echo "These data are equals to the current data, you do not needed to do this ;)";

								}

							} else {

								echo "Something went wrong while deleting you from the team.";

							}

						}

					} else {

						echo "This is not your team, you cannot edit it.";

					}

				} else {

					echo "Something went wrong, maybe this is the wrong team!";

				}

			} else {

				// Team form have not been submited so we display the form
				// Check if a project was selected
				if(isset($_GET['team_id'])){

					// Check if the the user is a member of the selected team
					$query = "SELECT team.id, team.name
							  FROM TeamAccount ta, Teams team
							  WHERE ta.account_id='".$_SESSION['id']."'
							  AND ta.team_id='".$_GET['team_id']."'
							  AND ta.team_id=team.id";

					if($result = mysqli_query($dbconn,$query)){

						if(mysqli_num_rows($result)==1){

							$team_data = mysqli_fetch_assoc($result);

							// Now show the project form
							require 'team_form.php';

						} else {

							echo "This is not your team, you cannot edit it.";

						}

					} else {

						echo "Something went wrong, maybe this is the wrong team!";

					}


				} else {

					echo "No team was selected.";

				}

			}

		?>


		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>