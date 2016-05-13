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
		
		<?php 

			// Define the project selected
			$project_id = "";
			if(isset($_POST['project_id']))	$project_id = $_POST['project_id'];
			else if (isset($_GET['project_id'])) $project_id = $_GET['project_id'];

			// Include the project functions
			require_once '../assets/php/Project_Functions.php';
			$project_func = new Project_Functions($_SESSION['id'],$project_id);

		?>


		<?php include '../assets/php/header.php'; ?>

		<?php 

			// Check if post data have been submited to be store
			if(isset($_POST['submit_project'])){

				// Project form have been submitted
				
				// Collect all the inputs
				$title = ""; $description = ""; $vision = ""; $milestones = [];
				if(isset($_POST['title'])) $title = $_POST['title'];
				if(isset($_POST['description'])) $description = $_POST['description'];
				if(isset($_POST['vision'])) $vision = $_POST['vision'];
				if(isset($_POST['milestones'])) $milestones = $_POST['milestones'];

				// Check if title is empty (The project title cannot be empty)
				if(trim($title)=="") die("The project title cannot be empty!");

				// Check if the user has the rights to edit the project
				if($project_data = $project_func->userProjectRights()) {

					if($project_data_updated = $project_func->updateProject($title,$description,$vision)) {

						$project_data = $project_data_updated;

						?>

							<h5>Project Updated</h5>
							<a href="./?team_id=<?php echo $_POST['team_id']; ?>">Back to your team</a>

						<?php

					} else {

						echo "Something went wrong, project details have not been updated.<br>";

					}

					if($milestones_data = $project_func->addMilestones($milestones)) {

						?>

							<h5>Milestones Updated</h5>
							<a href="./?team_id=<?php echo $_POST['team_id']; ?>">Back to your team</a>

						<?php

					} else {

						echo "Something went wrong, milestones have not been updated.<br>";

					}

					// Now show the project form
					require 'project_form.php';

				} else {

					echo "Something went wrong, maybe this is the wrong project!";

				}

			} else {

				// Project form have not been submited so we display the form
				// Check if a project was selected
				if(isset($_GET['project_id'])){

					// Check if the user has the rights to edit the project
					if($project_data = $project_func->userProjectRights()){

						// Get current project milestones
						if(!$milestones_data = $project_func->currentProjectMilestones()){

							echo "Error while reading the current milestones.";

						}

						// Now show the project form
						require 'project_form.php';

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