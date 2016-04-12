<?php

	if($projectID){


		$projects = mysqli_query($dbconn, "SELECT * FROM Project WHERE id='" . $projectID . "' ");

		if (mysqli_num_rows($projects) == 1) {

		    while($project = mysqli_fetch_assoc($projects)) {
			    
		    	?>

		    		<h3><?php print $project['title']; ?></h3>

		    		<p><?php print $project['description']; ?></p>

		    	<?php


		    	// here add the query to AccountProject table and get project members
		    	// ...

			}

		} else {
		    echo "No projects here!";
		}

		mysqli_close($dbconn);

	} else {

		echo "Hey there!";

	}

?>