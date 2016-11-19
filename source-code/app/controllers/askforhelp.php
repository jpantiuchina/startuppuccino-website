<?php
	
	
	include '../models/session.php';

	// Check for get paramaters
	if(!isset($_GET['e']) || !isset($_GET['i']) || !isset($_GET['m'])){
		exit("Some input is missing, please fill all the fields.");
	}

	// Parse inputs
	// ...

	// Check if the user_id is a correct registered user
	// ...

	if($userLogged){

		$object = "ASK FOR HELP - ".$_SESSION['firstname']." ".$_SESSION['lastname']." - ".$_GET['i'];

		// Send email
		if(mail("info@startuppuccino.com", $object, $_GET['m'], "From: ".$_GET['e'])){
			echo "ok";
		} else {
			echo "Error while sending the request.\nPlease try again later, or contact the professor.";
		}

	} else {

		echo "Error, you are not logged";

	}

?>