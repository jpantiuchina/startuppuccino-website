<?php

	if($ideaID){


		$ideas = mysqli_query($dbconn, "SELECT * FROM Ideas WHERE id='" . $ideaID . "' OR title='" . $ideaID . "'");

		if (mysqli_num_rows($ideas) == 1) {

		    while($idea = mysqli_fetch_assoc($ideas)) {
			    
		    	?>

		    		<!-- Temp html layout -->

		    		<div style="text-align: center;">

			    		<h3><?php print $idea['title']; ?></h3>

			    		<h5>DESCRIPTION</h5>

			    		<p><?php print $idea['description']; ?></p>

			    	</div>

		    	<?php


			}

		} else {
		    echo "No projects here!";
		}

		mysqli_close($dbconn);

	} else {

		echo "Hey there!";

	}

?>