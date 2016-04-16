<?php

	if($ideaID){


		$ideas = mysqli_query($dbconn, "SELECT * FROM Project WHERE id='" . $ideaID . "' OR title='" . $ideaID . "'");

		if (mysqli_num_rows($ideas) == 1) {

		    while($idea = mysqli_fetch_assoc($ideas)) {
			    
		    	?>

		    		<!-- Temp html layout -->

		    		<div style="text-align: center;">

			    		<h3><?php print $idea['title']; ?></h3>

			    		<h5>VISION</h5>

			    		<?php if(trim($idea['vision']) != ""){ ?>

				    		<p><?php print $idea['vision']; ?></p>
				    	
				    	<?php } else { ?>
				    	
				    		<p>This team needs more time to understand the vision</p>
				    	
				    	<?php } ?>

			    		<h5>DESCRIPTION</h5>

			    		<p><?php print $idea['description']; ?></p>

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