<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged) {
		header("Location: ../");
		exit;
	}

	// Include the Team Functions
	require_once '../app/models/Team_Functions.php';			

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
		
		<?php include '../app/views/header.php'; ?>


		<?php

			/* If isset the get parameter 'team_id' ( ../index.php?team_id=xxxx )
			links like ../teams/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			then the team details are diplayed instead of the list of teams */

			if(isset($_GET['team_id'])){

				// Show one team details

				$team_id = $_GET['team_id'];
				require 'team.php';

			} else {

				// Show all teams

				// Instantiate the Team Functions (without addressing any specific team)
				$team_func = new Team_Functions($_SESSION['id'],NULL);

			?>

				<section class="list_view">

					<?php

						if ($teams = $team_func->getAllTeams()){

							foreach ($teams as $team){
							
						        ?>

						        	<div class="list_element list_element--team">

						        		<div class="team__details">
						        			
						        			<?php 
						        				$team_pic_src = "../app/assets/pics/teams/".$team['pic'];
						        				if(!file_exists($team_pic_src)) $team_pic_src = "../app/assets/pics/startuppuccino_logo-white.svg";
						        			?>

							        		<img src="<?php echo $team_pic_src; ?>" class="team__details_pic" />
						        			<h3 class="team__details_title">
								        		<a href="./?team_id=<?php print $team['id']; ?>">
								        			<?php echo $team['name']; ?>
								        		</a>
								        	</h3>
							        	</div>

						        	</div>

						        <?php

						    }

						} else {
						    echo "No Teams here!";
						}

					?>

				</section>

			<?php

			} // endif switch all users list or single user details

			?>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>