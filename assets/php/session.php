<?php

	session_start();
	
	$userLogged = false;
	
	if(isset($_SESSION['firstname'])) {
		
		$userLogged = true;

	}

?>