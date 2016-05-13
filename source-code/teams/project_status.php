<?php 

	if($project_id != ""){

		$chart_data = [];

		// Store all the milestones in the array
		$query = "SELECT name FROM Milestones";
		$result = mysqli_query($dbconn,$query);
		while($row = mysqli_fetch_assoc($result)){
			$chart_data[$row['name']] = "";
		}

		$query = "SELECT m.name, pm.update_date
				  FROM ProjectMilestones pm, Milestones m
				  WHERE pm.project_id='".$project_id."'
				  AND m.id = pm.milestone_id";
		
		if($result = mysqli_query($dbconn,$query)){

			// Insert into data[] all the milestones reached
			while($row = mysqli_fetch_assoc($result)){
				$chart_data[$row['name']] = $row['update_date'];
			}

			if(count($chart_data)>1){

				// Print out the chart with reached milestones all the milestones
				?>

					<h4>PROJECT STATUS</h4>

					<div class="project_chart">

						<div class="milestone_wrapper">

						<?php foreach($chart_data as $milestone => $date){ ?>

							<div class="milestone">
									
								<span class="milestone__label"><?php echo $milestone; ?></span>
								<span class="milestone__date"><?php echo $date; ?></span>

								<?php if($date != null){ ?>

								<div class="milestone__dot"></div>

								<?php } ?>

							</div>

						<?php } ?>

						</div>

						<div class="project_chart__line">
							<hr />
							<div class="project_chart__line__arrow"></div>
						</div>

					</div>

				<?

			} else {

				// We do not have the right data so we do not print out the chart

			}

		} else {

			echo "No result from query";

		}

	} else {

		// Nothing to show

	}
	
?>