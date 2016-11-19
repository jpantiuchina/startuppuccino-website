<?php
	
	require_once '../app/models/session.php';

	require_once '../app/models/Credential_Functions.php';
	$credential_func = new Credential_Functions();

	$credential_func->setEmail($login_email);
	$reset = $credential_func->reset_password();

	// Set defalut values of email
	$login_data = ['email' => $login_email];


	$resetOk = ($reset & $reset != false);

	if($resetOk) {

	   	// Reload the page with a successfull message
	   	header("Location: ../login/?reset&reset_done");
	   	// Client redirect if header fails
	   	echo "<script>window.location='../login/?reset&reset_done'</script>";

	}

?>