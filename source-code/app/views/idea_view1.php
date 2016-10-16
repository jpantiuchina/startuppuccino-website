<?php

	// Set template name and variables
	
	$template_file = "ideas__phase1.twig";	

	$template_variables = [
				'ideas' => $ideas,
				'userLogged' => $userLogged,
				'user_id' => $_SESSION['id'],
				'default_avatar' => "idea_pic.png"
          	];
	
    // Render the template

    require_once '_Twig_Loader.php';
    return (new Twig_Loader())->render($template_file, $template_variables);

?>