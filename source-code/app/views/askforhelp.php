<?php
	
	// Set template name and variables
	
	$template_file = "all__askforhelp.twig";	

	$template_variables = [
				'user_id' => $_SESSION['id'],
				'user_email' => $_SESSION['email']
          	];


    // Render the template
    require_once '_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);

?>