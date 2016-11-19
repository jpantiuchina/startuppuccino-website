<?php

	$CONTROLLERS_DIR = __DIR__ ;
	$APP_DIR = dirname( $CONTROLLERS_DIR );


	require_once $CONTROLLERS_DIR . '/session.php';

	// Instantiate the CourseSession Functions
	require_once $APP_DIR . '/models/CourseSessions_Functions.php';
	$cs_func = new CourseSessions_Functions();

	if ($sessions_set = $cs_func->getSessions()){
	
		if($_SESSION['role']==="mentor"){ 
		
			include $APP_DIR . '/views/course_sessions_sidebar_mentor.php';
		
		}
		
		include $APP_DIR . '/views/course_sessions.php';

	} else {

		echo "No Lectures found!";

	}

?>