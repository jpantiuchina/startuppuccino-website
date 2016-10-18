<?php
	

	error_reporting(0);

	// Check for get paramaters
	if(!isset($_GET['e']) || !isset($_GET['i']) || !isset($_GET['m'])){
		exit("Some input is missing, please fill all the fields.");
	}

	// Parse inputs
	// ...

	// Check if the user_id is a correct registered user
	// ...

	// Send email
	if(mail("info@startuppuccino.com","ASK FOR HELP - ".$_GET['i'],$_GET['m'],"From: ".$_GET['e'])){
		echo "Request successfully sent!";
	} else {
		echo "Error while sending the request.\nPlease try again later, or contact the professor.";
	}

?>