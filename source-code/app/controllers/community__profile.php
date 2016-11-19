<?php

    $CONTROLLERS_DIR = __DIR__;
    $APP_DIR = dirname( $CONTROLLERS_DIR );


	require_once $CONTROLLERS_DIR . '/session.php';
	

	$socials = !empty($user["socials"]) ? json_decode(trim($user["socials"]),true) : array();
	foreach ( $socials as $social_label => $social_data ) {
	
		// Fix url format
		
		if($social_label == "skype"){
			$social_data[0] = "skype:".$social_data[0];
		} else if($social_label == "whatsapp"){
			$social_data[0] = "whatsapp://".$social_data[0];
		} else if($social_label == "telegram"){
			// ...
		} else if(substr($social_data[0], 0, 7) == 'http://'){
			$social_data[0] = "//".substr($social_data[0], 6);
		} else if(substr($social_data[0], 0, 8) == 'https://'){
			$social_data[0] = "//".substr($social_data[0], 7);
		} else {
			$social_data[0] = "//".$social_data[0];
		}
		
		
		$socials[$social_label] = $social_data;

	}


	// Set template variables
	
	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['is_my_profile'] = $people_func->isMyProfile();
	$template_variables['socials'] = $socials;
	$template_variables['user'] = $user;

?>