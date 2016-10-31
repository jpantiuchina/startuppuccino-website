<?php
	
	// Socials array example:
	// ["facebook"=>["https://facebook.com/user/helloworld","primary"],"twitter"=>["https://twitter.com/user/helloworld","secondary"]]
			
	$socials = !empty($user["socials"]) ? json_decode(trim($user["socials"]),true) : array();
	for ( $socials as $social_label => $social_data ) {
	
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


	// Set template name and variables
	
	$template_file = "community__profile.twig";	

	$template_variables = [
				'sess' => $_SESSION,
				'userLogged' => $userLogged,
				'is_my_profile' => $people_func->isMyProfile(),
				'socials' => $socials
          	];


    // Render the template
    require_once '_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);

?>