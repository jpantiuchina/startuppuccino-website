<?php
	
	$servername = "localhost";
	$db_username = "username";
	$db_password = "password";

	// Create connection
	$dbconn = mysqli_connect($servername, $db_username, $db_password);

	// Check connection
	if (!$dbconn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

?>