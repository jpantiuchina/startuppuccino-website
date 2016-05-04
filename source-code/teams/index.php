<?php

	include '../assets/php/session.php';

	include '../assets/php/db_connect.php';

	// Redirect to home if user is not logged
	if(!$userLogged) header("Location: ../");

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/team.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/listview.css">
		<title>Startuppuccino - Teams</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>


		<?php
			 /* If isset the get parameter 'team_id' ( ../index.php?team_id=xxxx )
			 links like ../projects/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			 then the project details are diplayed instead of the list of projects */
		?>

		<?php if (isset($_GET['team_id'])){ ?>

			<!-- Project details -->

			<?php

				$teamID = $_GET['team_id'];

				include 'team.php';

			?>

		<?php } else { ?>

			<!-- Projects list -->

			<?php $teams = mysqli_query($dbconn, "SELECT * FROM Teams"); ?>

			<br><br>

			<section class="list_view">

				<?php

					if (mysqli_num_rows($teams) > 0){

						//echo mysqli_num_rows($teams);

						foreach ($teams as $team){
						
					        ?>

					        	<div class="card">

					        		<div class="card__details card__details--project">
						        		<a href="./?team_id=<?php print $team['id']; ?>">
							        		
							        		<span class="card__details_name">
							        			<?php print $team['name']; ?>
							        		</span>
						        		
						        		</a>
						        	</div>

					        	</div>

					        <?php

					    }

					} else {
					    echo "No Teams here!";
					}

					mysqli_close($dbconn);

				?>

			</section>

		<?php } // endif switch all users list or single user details ?>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>