<?php

	if($projectID){


		$projects = mysqli_query($dbconn, "SELECT * FROM Project WHERE id='" . $projectID . "' OR title='" . $projectID . "'");

		if (mysqli_num_rows($projects) == 1) {

		    while($project = mysqli_fetch_assoc($projects)) {
			    
		    	?>

		    		<!-- Temp html layout -->

		    		<div style="text-align: center;">

			    		<h3><?php print $project['title']; ?></h3>

			    		<h5>VISION</h5>

			    		<?php if(trim($project['vision']) != ""){ ?>

				    		<p><?php print $project['vision']; ?></p>
				    	
				    	<?php } else { ?>
				    	
				    		<p>This team needs more time to understand the vision</p>
				    	
				    	<?php } ?>

			    		<h5>DESCRIPTION</h5>

			    		<p><?php print $project['description']; ?></p>

			    	</div>

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