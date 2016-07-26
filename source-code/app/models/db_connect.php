<?php
	
	$servername = "localhost";
	$db_username = "cappuccino";
	$db_password = "startup7";
	$db_name = "startuppuccino";

	// Create connection
	$dbconn = mysqli_connect($servername, $db_username, $db_password, $db_name);

	// Check connection
	if (!$dbconn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

?>