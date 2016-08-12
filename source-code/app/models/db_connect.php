<?php
	
	require_once 'database/DB_Names.php';
	require_once 'database/DB_Config.php';

	// Create connection
	$dbconn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

	// Check connection
	if (!$dbconn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

?>