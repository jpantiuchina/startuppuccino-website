<?php

	session_start();

	include dirname( __DIR__ ) . '/logout.php';

	header("Location: ../");

?>