<?php
	
	// Prevent showing errors
	//error_reporting(0);

	session_start();

	$userLogged = isset($_SESSION['firstname']);	


	// Load Config
   	require_once dirname( __DIR__ ) . '/models/Config_Functions.php';
   	$config_func = new Config_Functions();
   	// Load ideas settings
   	$config_func->load();

   	
	// Check if the user required to stay logged in
	if(!$userLogged){

		// Get required_logged_id cookie
		$cookie_token = isset($_COOKIE['permalog']) ? $_COOKIE['permalog'] : null;

		if( $cookie_token != null ){

			// Connect to database
			require_once dirname( __DIR__ ) . '/models/database/DB_Connect.php';
			$db = new Db_Connect();
			$dbconn = $db->connect();

	        $query = "SELECT l.account_id 
			          FROM "._T_ACCOUNT_LOGGED." AS l 
			          WHERE l.cookie_token='" . $cookie_token . "';";

			if( $result = $dbconn->query($query) ){
	        		
	        	$result = $result->fetch_assoc();

	        	// AUTOMATIC LOG IN

	        	// Automatically log in the the account
		        $query = "SELECT id, about, avatar, background, skills, email, firstname, lastname, role 
	                      FROM "._T_ACCOUNT." 
	                      WHERE id='" . $result['account_id'] . "'";

	            $result = $dbconn->query($query);

				// query result is ok if only one match is found (one account)
				if( $result && $result->num_rows == 1 ){

					$account_data = $result->fetch_assoc();

					// Set session data
					foreach ($account_data as $key => $value) { $_SESSION[$key] = $value; }

				   	$userLogged = isset($_SESSION['firstname']);

				}

			}

	    }

	}



	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	
	$isStudent = (isset($_SESSION['role']) && $_SESSION['role']=="student");
	$isMentor = (isset($_SESSION['role']) && $_SESSION['role']=="mentor");
	$isGuest = (isset($_SESSION['role']) && $_SESSION['role']=="guest");
	$isEducator = (isset($_SESSION['role']) && $_SESSION['role']=="educator");

?>