<?php
	
	require_once '../app/models/session.php';
    require_once '../app/views/_Twig_Loader.php';

	// Switch between different ideas phases
	// Set template name and variables
    $ideas_phase = isset($_SESSION['ideas_phase']) ? $_SESSION['ideas_phase'] : 0;
	
	$template_variables = [
							'ideas' => $ideas,
							'sess' => $_SESSION,
							'userLogged' => $userLogged,
							'isStudent' => $isStudent,
							'default_avatar' => "idea_pic.png"
						];


	$template_file = "ideas__phase" . $ideas_phase . ".twig";

	return (new Twig_Loader())->render($template_file, $template_variables);

?>