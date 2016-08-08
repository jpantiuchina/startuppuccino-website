<?php
	
	require_once '../app/models/session.php';

	// Switch between different ideas phases

	$ip = isset($_SESSION['ideas_phase']) ? $_SESSION['ideas_phase'] : 0;

	switch ($ip) {
		case 1:
		
			$view = include 'idea_view1.php';			
			break;
		
		case 2:
		
			$view = include 'idea_view2.php';			
			break;
		
		case 3:
			
			$view = include 'idea_view3.php';			
			break;
		
		default:
			$view = include 'idea_view0.php';			
			break;
	}

	return $view;

?>