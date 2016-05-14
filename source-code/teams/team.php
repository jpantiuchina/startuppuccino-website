<?php

	if($team_id){

		// Instantiate the Team Functions
		$team_func = new Team_Functions($_SESSION['id'],$team_id);

		if ($team = $team_func->getTeamInfo()) {
			    
		    	?>

		    		<!-- Temp html layout -->

		    		<div style="max-width: 600px;margin: auto">

			    		<h2><?php print $team['name']; ?></h2>

			    		<?php 
			    			// Team mentor not yet implemented 
			    			// todo: Add mentor field in Teams database
			    		?>
			    		<?php if(trim($team['mentor']) != ""){ ?>

			    			<h4>MENTOR</h4>

				    		<p><?php print $team['mentor']; ?></p>
				    	
				    	<?php } ?>

			    		<h4>MEMBERS</h4>


			    		<?php // list all the members
			    			
				    		foreach ($team['members'] as $member) {
				    			
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

			    			if ($project = $team_func->getTeamProject()) {

				    			$project_id = $project['id'];
				    			
				    			?>

				    				<div><b>Title: </b><?php print $project['title']; ?></div>
				    				<div><b>Description: </b><?php print $project['description']; ?></div>
				    				<div><b>Vision: </b><?php print $project['vision']; ?></div>
				    				<div><b>Last Pivot: </b><?php print $project['updated_date']; ?></div>

				    			<?php

							} else {

								echo "Project not found.";

							}

				    	?>

					    <?php 

					    	// PROJECT STATUS
					    	include 'project_status.php'; 

					    ?>				    	

			    	</div>

		    	<?php


			// Boolean set in the member listing above
			if ($isMyTeam){	?>

				<section class="center custom_padding--20">
					<span class="button button--big"><a href="./edit_project.php?project_id=<?php echo $project_id;?>">Edit Project</a></span>
				</section>

				<section class="center custom_padding--20">
					<span class="button button--big"><a href="./edit_team.php?team_id=<?php echo $team_id;?>">Edit Team</a></span>
				</section>

			<?php } // endif isMyTeam

		} else {
		    echo "No team here!";
		}

	} else {

		echo "Hey there!";

	}

?>