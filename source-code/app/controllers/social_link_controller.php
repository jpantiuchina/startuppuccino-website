<?php

	// Receive http request from client with the new social links to be saved

	// Start session
	require_once '../models/session.php';

	// Check if the parameter socialdata is set
	if(!isset($_POST['socialdata']) || empty($_POST['socialdata'])){
		exit('There are no data to be saved.');
	}

	// Include People functions
	require_once '../models/Account_Functions.php';
	$account_func = new Account_Functions($_SESSION['id']);

	// Save the socialdata
	if($account_func->saveSocialdata($_POST['socialdata'])){
		exit("ok");
	}

	echo "Error while saving data, please try again.";

?>