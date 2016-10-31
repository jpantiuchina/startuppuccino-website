<?php
	
	require_once '../app/models/session.php';
    require_once '../app/views/_Twig_Loader.php';

	// Switch between different ideas phases
	// Set template name and variables
    $ideas_phase = isset($_SESSION['ideas_phase']) ? $_SESSION['ideas_phase'] : 0;
	
	$template_variables['ideas'] = $ideas;
	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['isStudent'] = $isStudent;
	$template_variables['default_avatar'] = "idea_pic.png";
	$template_variables['idea_phase_template'] = "ideas__phase" . $ideas_phase . ".twig";

?>