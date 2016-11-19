<?php
	
	require_once '../../../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../../");
		exit;
	}

	require '../../../app/models/db_connect.php';

?>


<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../../../app/assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../../../app/assets/css/listview.css">
		<title>Ideas Manager - Startuppuccino</title>

	</head>
	<body>
		
		<div class="listview">

		<div class="line_element line_element--header">
			<span class="line_element__cell">Owner</span>
			<span class="line_element__cell">Title</span>
			<span class="line_element__cell">N^ Members</span>
		</div>

		<?php

			// List all the ideas

		$query = "SELECT i.title,
                       i.description,
                       i.ideal_team_size,
                       (SELECT COUNT(*) FROM project_participant WHERE project_id = i.id) + 1 AS current_team_size,
                       i.date,
                       i.avatar,
                       a.firstName, 
                       a.lastName,
                       i.id,
                       i.owner_id
                    FROM "._T_IDEA." i JOIN "._T_ACCOUNT." a ON i.owner_id = a.id WHERE NOT a.is_approved";

			if($ideas = mysqli_query($dbconn,$query)){

				while($idea = mysqli_fetch_assoc($ideas)){

					?>

					<div class="line_element" <?php if($idea['approved']==="F"){echo 'style="opacity:0.5"';} ?>>
						<span class="line_element__cell"><?php echo $idea['firstName']." ".$idea['lastName']; ?></span>
						<span class="line_element__cell"><?php echo $idea['title']; ?></span>
						<span class="line_element__cell"><?php echo $idea['current_team_size']."/".$idea['team_size']; ?></span>

						<?php if($idea['approved']==="T"){ ?>

							<span class="line_element__cell line_element__cell--button" style="backgorund-color:#d77" onclick="disapprove('<?php echo $idea['id'];?>')">Disapprove</span>
	
						<?php } else { ?>

							<span class="line_element__cell line_element__cell--button" onclick="approve('<?php echo $idea['id'];?>')">Approve</span>

						<?php } ?>

					</div>

					<?php

				}

			} else {

				die("Error, it was not possible to get any idea from the database. ".mysqli_error($dbconn));

			}



		?>

		</div> <!-- Listview -->

		<script src="../../../app/assets/js/startuppuccino.js"></script>
		<script src="../../../app/assets/js/educators.js"></script>

	</body>
</html>