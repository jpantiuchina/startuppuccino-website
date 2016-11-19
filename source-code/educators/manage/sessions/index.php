<?php
	
	require_once '../../../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../../");
		exit;
	}

	// Connect db
	// Delete account record from db
	require_once '../../../app/models/database/DB_Connect.php';
	$db = new Db_Connect();
	$dbconn = $db->connect()

?>


<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../../../app/assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../../../app/assets/css/listview.css">
		<title>Sessions Manager - Startuppuccino</title>

	</head>
	<body>
		
		<div class="listview">

		<?php

		// List all the ideas

		$query = "SELECT s.title, ma.session_id, 
		                 ma.mentor_id, a.avatar, a.firstName, a.lastName, 
		                 ma.pitch, ma.pitch_approved
                  FROM "._T_ACCOUNT." AS a, "._T_MENTOR_AVAILABILITY." AS ma, "._T_SESSION." AS s
                  WHERE ma.mentor_id = a.id
                  AND   ma.session_id = s.id;";

			if($result = $dbconn->query($query)){

				while( $x = $result->fetch_assoc() ){
					echo "<div style='margin:20px'>";
					foreach ($x as $key => $value) {
						echo "<p>".$key." => ".$value."</p>";
					}
					echo "<br><br><hr><br><br></div>";
				}

			} else {

				die("Error, it was not possible to get any data from the database. ".mysqli_error($dbconn));

			}



		?>

		</div> <!-- Listview -->

		<script src="../../../app/assets/js/startuppuccino.js"></script>
		<script src="../../../app/assets/js/educators.js"></script>

	</body>
</html>