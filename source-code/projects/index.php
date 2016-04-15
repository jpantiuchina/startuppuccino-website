<?php

	include '../assets/php/session.php';

	include '../assets/php/db_connect.php';

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/listview.css">
		<title>Startuppuccino - Projects</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>


		<?php 
			/* 
				Here we have the section visible only if the user is logged. 
				This section contains the buttons to manage and create the projects.
			*/
		?>

		<?php if ($userLogged){ ?>

			<section>
				<span class="button button--big" onclick="showSection('my_projects')">My Projects</span>
				<span class="button button--big" onclick="showSection('new_project')">New Project</span>
			</section>

			<section id="my_projects">
				<ul>
				</ul>
			</section>

			<section id="new_project">
				
				<?php include 'project_form.php'; ?>

			</section>

		<?php } // end if user is logged ?>


		<?php
			 /* If isset the get parameter 'p_id' ( ../index.php?p_id=xxxx )
			 links like ../projects/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			 then the project details are diplayed instead of the list of projects */
		?>

		<?php if (isset($_GET['p_id'])){ ?>

			<!-- Project details -->

			<?php

				$projectID = $_GET['p_id'];

				include 'project.php';

			?>

		<?php } else { ?>

			<!-- Projects list -->

			<?php $projects = mysqli_query($dbconn, "SELECT * FROM Project"); ?>

			<br><br>

			<section class="list_view">

				<?php

					if (mysqli_num_rows($projects) > 0){

						//echo mysqli_num_rows($projects);

						foreach ($projects as $project){
						
					        ?>

					        	<div class="card">

					        		<div class="card__details card__details--project">
						        		<a href="./?p_id=<?php print $project['id']; ?>">
							        		<span class="card__details_name">
							        			<?php print $project['title']; ?>
							        		</span>
							        		<span class="card__details_description">
							        			<?php print $project['description']; ?>
							        		</span>
						        		</a>
						        	</div>

					        	</div>

					        <?php

					    }

					} else {
					    echo "No projects here!";
					}

					mysqli_close($dbconn);

				?>

			</section>

		<?php } // endif switch all users list or single user details ?>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>