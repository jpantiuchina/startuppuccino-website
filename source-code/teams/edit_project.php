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
		<title>Startuppuccino - Edit Project</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

		<?php 

			// TODO: improve security!!!

			// Check if post data have been submited to be store
			if(isset($_POST['submit_project'])){

				// Project form have been submited
				
				$title = ""; $description = ""; $vision = "";
				if(isset($_POST['title'])) $title = $_POST['title'];
				if(isset($_POST['description'])) $description = $_POST['description'];
				if(isset($_POST['vision'])) $vision = $_POST['vision'];
				if(isset($_POST['project_id'])) $project_id = $_POST['project_id'];

				// Check if the project_id is set and user is has the rights to edit it
				// TODO: Improve --> same code copied below
				$query = "SELECT p.id 
							  FROM TeamAccount ta, Project p, Teams team
							  WHERE ta.account_id='".$_SESSION['id']."'
							  AND p.id='".$project_id."'
							  AND ta.team_id=team.id
							  AND p.team_id=team.id";

				if($result = mysqli_query($dbconn,$query)){

					if(mysqli_num_rows($result)==1){

						// Check if title is empty (The project title cannot be empty)
						if(trim($title)=="") die("The project title cannot be empty!");

						// Update data in the database				
						$query = "UPDATE Project 
								  SET updated_date=NOW(),
								  	  title='".$title."',
								  	  description='".$description."',
								  	  vision='".$vision."'
								  WHERE id='".$project_id."'";

						if($result = mysqli_query($dbconn,$query)){

							if(mysqli_affected_rows($dbconn)==1){

								?>

									<h5>Project Updated</h5>
									<a href="./?team_id=<?php echo $_POST['team_id']; ?>">Back to your team</a>

								<?php

							} else if(mysqli_affected_rows($dbconn)<1){

								echo "Something went wrong, please try again.";

							} else {

								echo "These data are equals to the current data, you do not needed to do this ;)";
								?> <a href="./?team_id=<?php echo $_POST['team_id']; ?>">Back to your team</a> <?php

							}

						} else {

							echo "Something went wrong.";

						}

					} else {

						echo "This is not your team project, you cannot edit it.";

					}

				} else {

					echo "Something went wrong, maybe this is the wrong project!";

				}

			} else {

				// Project form have not been submited so we display the form
				// Check if a project was selected
				if(isset($_GET['project_id'])){

					// Check if the the user is a member of the selected project
					$query = "SELECT p.id, p.title, p.description, p.vision, p.team_id
							  FROM TeamAccount ta, Project p, Teams team
							  WHERE ta.account_id='".$_SESSION['id']."'
							  AND p.id='".$_GET['project_id']."'
							  AND ta.team_id=team.id
							  AND p.team_id=team.id";

					if($result = mysqli_query($dbconn,$query)){

						if(mysqli_num_rows($result)==1){

							$project_data = mysqli_fetch_assoc($result);

							// Now show the project form
							require 'project_form.php';

						} else {

							echo "This is not your team project, you cannot edit it.";

						}

					} else {

						echo "Something went wrong, maybe this is the wrong project!";

					}


				} else {

					echo "No project was selected.";

				}

			}

		?>


		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>