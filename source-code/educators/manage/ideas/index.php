<?php
	
	require '../../../assets/php/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../../");
		exit;
	}

	require '../../../assets/php/db_connect.php';

?>


<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../../../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../../../assets/css/listview.css">
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

			$query = "SELECT i.id, a.firstName, a.lastName, i.title, i.current_team_size, i.team_size
					  FROM Ideas i, Account a WHERE i.owner_id=a.id;";
			if($ideas = mysqli_query($dbconn,$query)){

				while($idea = mysqli_fetch_assoc($ideas)){

					?>

					<div class="line_element 
						<?php if($idea['team_size']==$idea['current_team_size']) echo "line_element--fluo"; ?>
					">
						<span class="line_element__cell"><?php echo $idea['firstName']." ".$idea['lastName']; ?></span>
						<span class="line_element__cell"><?php echo $idea['title']; ?></span>
						<span class="line_element__cell"><?php echo $idea['current_team_size']."/".$idea['team_size']; ?></span>

						<span class="line_element__cell line_element__cell--button" onclick="upgradeIdea('<?php echo $idea['id'];?>')">Upgrade</span>

					</div>

					<?php

				}

			} else {

				die("Error, it was not possible to get any idea from the database. ".mysqli_error($dbconn));

			}



		?>

		</div> <!-- Listview -->

		<script src="../../../assets/js/general.js"></script>
		<script src="../../../assets/js/educators.js"></script>

	</body>
</html>