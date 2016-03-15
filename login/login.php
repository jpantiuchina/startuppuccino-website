<?php
	
	include '../assets/php/session.php';

	if( !$userLogged
		&& ( ($new_account_email != "" && $new_account_password != "") 
		||   (isset($_POST['login'])) ) ) {

		include '../assets/php/db_connect.php';

		if(isset($_POST['login'])){
			$login_mail = $_POST['email'];
			$login_password = $_POST['password'];
		} else {
			$login_mail = $new_account_email;
			$login_password = $new_account_password;
		}

		$account = mysqli_query($dbconn, "SELECT id, avatar, background, email, firstname, lastname, role FROM Account WHERE email='" . $login_mail . "' AND password='" . $login_password . "'");

		if (mysqli_num_rows($account) == 1) {

		    while($row = mysqli_fetch_assoc($account)) {
		        foreach ($row as $key => $value) {
		        	$_SESSION[$key] = $value;
		        }
		    }

		} else {
		    echo "Nobody is here!";
		}

		mysqli_close($dbconn);

	} else {
		echo ":)";
	}

?>