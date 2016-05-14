<?php

	if($teamID){

		// default variable
		$isMyTeam = false;

		$teams = mysqli_query($dbconn, "SELECT * FROM Teams WHERE id='" . $teamID . "' OR name='" . $teamID . "'");

		if (mysqli_num_rows($teams) == 1) {

		    while($team = mysqli_fetch_assoc($teams)) {
			    
		    	?>

		    		<!-- Temp html layout -->

		    		<div style="max-width: 600px;margin: auto">

			    		<h2><?php print $team['name']; ?></h2>

			    		<?php 
			    			// Team mentor not yet implemented 
			    			// Add mentor field in Teams database
			    		?>
			    		<?php if(trim($team['mentor']) != ""){ ?>

			    			<h4>MENTOR</h4>

				    		<p><?php print $team['mentor']; ?></p>
				    	
				    	<?php } ?>

			    		<h4>MEMBERS</h4>


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

				    				<div>
				    					<a href="../people/?user_id=<?php print $member['id']; ?>"><?php print $member['firstName'] . " " . $member['lastName']; ?></a>
				    					<span> <?php print $member['background']; ?></span>
				    				</div>

				    			<?php

				    			// Check if the user is looking at his own team page
				    			if ($member['id'] == $_SESSION['id']) $isMyTeam = true;

				    		}


				    	?>





				    	<h4>PROJECT</h4>


			    		<?php // project details

			    			$query = "SELECT * FROM Project WHERE team_id = " . $team['id'];

				    		$projects = mysqli_query($dbconn, $query);

				    		if (mysqli_num_rows($projects) == 1) {

					    		foreach ($projects as $project) {

					    			$project_id = $project['id'];
					    			
					    			?>

					    				<div><b>Title: </b><?php print $project['title']; ?></div>
					    				<div><b>Description: </b><?php print $project['description']; ?></div>
					    				<div><b>Vision: </b><?php print $project['vision']; ?></div>
					    				<div><b>Last Pivot: </b><?php print $project['updated_date']; ?></div>

					    			<?php

					    		}

							} else {

								print "How did you make more projects????";

							}

				    	?>

					    <?php 

					    	// PROJECT STATUS
					    	include 'project_status.php'; 

					    ?>				    	

			    	</div>

		    	<?php

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