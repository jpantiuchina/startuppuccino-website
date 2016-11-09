<?php

	// Start session
	require_once '../models/session.php';

	// Check if the parameter is set
	if(!isset($_POST['s_id']) || empty($_POST['s_id']) ||
	   !isset($_POST['action']) || empty($_POST['action']) ){
		exit("Some parameter is missing.");
	}

	// 
	require_once '../models/StartupProject_Functions.php';
	$cs_func = new StartupProject_Functions();	

	

	// ...



	echo "Error while saving data, please try again.";


?>