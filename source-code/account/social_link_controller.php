<?php

	// Receive http request from client with the new social links to be saved

	echo $_POST['socialdata'];
exit;
	// Start session
	require '../assets/php/session.php';

	// Check if the parameter socialdata is set
	if(!isset($_POST['socialdata'])){
		die('There are no data to be saved.');
	}

	// Include People functions
	require_once '../assets/php/Account_Functions.php';
	$account_func = new Account_Functions($_SESSION['id']);

	// Save the socialdata
	echo $account_func->saveSocialdata($_POST['socialdata']);

?>