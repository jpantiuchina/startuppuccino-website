<?php


	// Set template name and variables
	
	$template_file = "ideas__phase3.twig";	

	$template_variables = [
				'ideas' => $ideas,
				'userLogged' => $userLogged,
				'isStudent' => $isStudent,
				'default_avatar' => "idea_pic.png"
          	];
	
    // Render the template

    require_once '_Twig_Loader.php';
    return (new Twig_Loader())->render($template_file, $template_variables);

?>