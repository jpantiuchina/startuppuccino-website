<?php 

	if($project_id != ""){

		// Initialize Project Functions
		// Include the project functions
		require_once '../assets/php/Project_Functions.php';
		$project_func = new Project_Functions($_SESSION['id'],$project_id);

		$chart_data = $project_func->currentProjectMilestones();

		if($chart_data && count($chart_data)>1){

			// Print out the milestones project chart
			?>

				<h4>PROJECT STATUS</h4>

				<div class="project_chart">

					<div class="milestone_wrapper">

					<?php foreach($chart_data as $milestone_id => $milestone){ ?>

						<div class="milestone">
								
							<span class="milestone__label"><?php echo $milestone['name']; ?></span>
							<span class="milestone__date"><?php echo $milestone['date']; ?></span>

							<?php if($milestone['date'] != null){ ?>

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

		// Nothing to show

	}
	
?>