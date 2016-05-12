<?php 

	if($project_id != ""){

		$query = "SELECT * FROM ProjectMilestones WHERE project_id='".$project_id."'";
		$result = mysqli_query($dbconn,$query);

		$data = [];

		if($result){

			$result = mysqli_fetch_assoc($result);

			// Insert into data[] all the milestones reached
			foreach ($result as $key => $value) {
				if($key != "project_id"){
					$data[$key] = $value;
				}
			}

			// Print out the chart with reached milestones all the milestones
			?>

				<div class="project_chart">

					<div class="milestone_wrapper">

					<?php foreach($data as $milestone => $date){ ?>

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

			echo "No result from query";

		}

	} else {

		// Nothing to show

	}
	
?>