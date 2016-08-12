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

			$query = "SELECT i.id, a.firstName, a.lastName, i.title, i.current_team_size, i.team_size, i.approved
					  FROM "._T_IDEA." i, "._T_ACCOUNT." a WHERE i.owner_id=a.id;";
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

		<script src="../../../app/assets/js/general.js"></script>
		<script src="../../../app/assets/js/educators.js"></script>

	</body>
</html>