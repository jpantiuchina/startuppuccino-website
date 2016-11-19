<?php
	
	require_once '../../../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../../");
		exit;
	}

?>

<!DOCTYPE html>
<html>
<head>

	<title></title>

	<style>
		body {margin: 0px; padding: 0px;background-color: #f2f2f2; color: #222}

		p, span {
			height: auto;
			overflow: hidden;
		}

		p {
			border-bottom: 2px solid #222;
		}

		span {
			display: inline-block;
			width: 200px;
			min-height: 40px;
			line-height: 40px;			
		}

		span.id {
			color: #555;
			width: 50px;
			text-align: center;
		}

		span.role. {
			font-weight: 900;
		}

		span.student {
			color: green;
		}

		span.guest {
			color: #
		}

		span.background {
			color: #c36506;
		}

	</style>

</head>
<body>

<main>
<?php 

	
	include '../../../app/models/database/DB_Connect.php';
	$db = new DB_Connect();
	$dbconn = $db->connect();

	// Number of students
	
	$query = "SELECT id FROM account WHERE role='student';";
	$result = $dbconn->query($query);
	if($result){
		echo "<h2>Number of students: " . $result->num_rows . "</h2>";
	}


	// Number of students
	
	$query = "SELECT id FROM account WHERE role='mentor';";
	$result = $dbconn->query($query);
	if($result){
		echo "<h2>Number of mentors: " . $result->num_rows . "</h2>";
	}


	?> <br><br> <?php

	// List of all accounts

	$query = "SELECT id, role, background, firstName, lastName, skills, email, created_at FROM account;";
	$result = $dbconn->query($query);
	if($result){
		while ($row = $result->fetch_assoc()) {
			?> <p class="user"> <?php
			foreach ($row as $key => $value) {
					?> <span class="<?php echo $key; ?>"> <?php
						echo $value;
					?> </span> <?php
			}
			?> </p><br> <?php
		}
	}

?>
</main>
</body>
</html>