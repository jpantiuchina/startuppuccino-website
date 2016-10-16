<?php
	
	// Set template name and variables
	
	$template_file = "ideas__form.twig";	

	$template_variables = [];


    // Render the template

    require_once '_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);

?>