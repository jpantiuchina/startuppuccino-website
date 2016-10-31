<?php

	require_once '../app/models/session.php';

	// Instantiate the CourseSession Functions
	require_once '../app/models/CourseSessions_Functions.php';
	$cs_func = new CourseSessions_Functions();

	if ($sessions_set = $cs_func->getSessions()){
	
		if($_SESSION['role']==="mentor"){ 
		
			include '../app/views/course_sessions_sidebar_mentor.php';
		
		}
		
		include '../app/views/course_sessions.php';

	} else {

		echo "No Lectures found!";

	}

?>