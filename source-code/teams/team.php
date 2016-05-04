<?php

	if($teamID){

		// default variable
		$isMyTeam = false;


		$teams = mysqli_query($dbconn, "SELECT * FROM Teams WHERE id='" . $teamID . "' OR name='" . $teamID . "'");

		if (mysqli_num_rows($teams) == 1) {

		    while($team = mysqli_fetch_assoc($teams)) {
			    
		    	?>

		    		<!-- Temp html layout -->

		    		<div style="text-align: center;">

			    		<h3><?php print $team['name']; ?></h3>

			    		<?php if(trim($team['mentor']) != ""){ ?>

			    			<h5>MENTOR</h5>

				    		<p><?php print $team['mentor']; ?></p>
				    	
				    	<?php } ?>

			    		<h5>MEMBERS</h5>


			    		<?php // list all the members

			    			$query = "SELECT a.firstName, a.lastName, a.background, a.id 
			    					  FROM TeamAccount ta, Account a, Teams t
			    					  WHERE ((ta.team_id = '". $teamID ."' AND t.id = ta.team_id)
			    					  		 OR
			    					  	 	 (t.name = '". $teamID ."' AND t.id = ta.team_id))
			    					  	 	AND ta.account_id = a.id";

				    		$members = mysqli_query($dbconn, $query);

				    		foreach ($members as $member) {
				    			
				    			?>

				    				<li>
				    					<a href="../people/?user_id=<?php print $member['id']; ?>">
				    						<?php print $member['firstName'] . " " . $member['lastName']; ?>
				    					</a>
				    					<p><?php print $member['background']; ?></p>
				    				</li>

				    			<?php

				    			// Check if the user is looking at his own team page
				    			if ($member['id'] == $_SESSION['id']) $isMyTeam = true;

				    		}


				    	?>





				    	<h5>PROJECT</h5>


			    		<?php // project details

			    			$query = "SELECT * FROM Project WHERE team_id = " . $team['id'];

				    		$projects = mysqli_query($dbconn, $query);

				    		if (mysqli_num_rows($projects) == 1) {

					    		foreach ($projects as $project) {

					    			$project_id = $project['id'];
					    			
					    			?>

					    				<h5><?php print $project['title']; ?></h5>
					    				<p><?php print $project['description']; ?></p>
					    				<h6><?php print $project['vision']; ?></h6>
					    				<p>Last Pivot: <?php print $project['updated_date']; ?></p>

					    			<?php

					    		}

							} else {

								print "How did you make more projects????";

							}

				    	?>




			    	</div>

		    	<?php


		    	// here add the query to AccountProject table and get project members
		    	// ...

			}

			// Boolean set in the member listing above
			if ($isMyTeam){	?>

				<section class="center custom_padding--20">
					<span class="button button--big"><a href="./edit_project.php?project_id=<?php echo $project_id;?>">Edit Project</a></span>
				</section>

				<section class="center custom_padding--20">
					<span class="button button--big"><a href="./edit_team.php?team_id=<?php echo $teamID;?>">Edit Team</a></span>
				</section>

			<?php } // endif isMyTeam

		} else {
		    echo "No team here!";
		}

		mysqli_close($dbconn);

	} else {

		echo "Hey there!";

	}

?>