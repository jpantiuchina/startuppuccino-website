<?php
	
	// TODO -> move this to controllers and db queries on credential_functions


	session_start();
	
	$userLogged = isset($_SESSION['firstname']);

	// Check if the user required to stay logged in
	if(!$userLogged){

		// Get required_logged_id cookie
		$cookie_token = isset($_COOKIE['permalog']) ? $_COOKIE['permalog'] : "";

		if( !empty($cookie_token) ){
			
			// Connect to database
			require_once 'database/DB_Connect.php';
			$db = new Db_Connect();
			$dbconn = $db->connect();

	        $query = "SELECT l.account_id 
			          FROM "._T_ACCOUNT_LOGGED." AS l 
			          JOIN "._T_ACCOUNT."        AS a 
			          ON l.account_id=a.id 
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

					// Load Config
				   	require_once 'Config_Functions.php';
				   	$config_func = new Config_Functions();
				   	// Load ideas settings
				   	$config_func->load();
				   	

				   	$userLogged = isset($_SESSION['firstname']);

				}

			}

	    }
	}

?>