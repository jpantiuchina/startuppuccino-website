<?php 

// Check if current data are set
if(count($project_data)>1){

	?>

		<form class="form_custom form_custom--slim" action="" method="post">

			<li class="form_box_item">
				<label for="title">Project Title</label>
				<input class="form_pretty_general_input" type="text" name="title" value="<?php echo $project_data['title'];?>" required/>
			</li>
			
			<li class="form_box_item">
				<label for="vision">Vision</label>
				<textarea class="form_pretty_general_input" name="vision" /><?php echo $project_data['vision'];?></textarea>
			</li>
			
			<li class="form_box_item">
				<label for="description">Project description</label>
				<textarea class="form_pretty_general_input" name="description" /><?php echo $project_data['description'];?></textarea>
			</li>

			<input type="hidden" name="project_id" value="<?php echo $project_data['id'];?>" />
			<input type="hidden" name="team_id" value="<?php echo $project_data['team_id'];?>" />

			<li class="form_box_item">
				<input class="form_pretty_button_input" type="submit" name="submit_project" value="SAVE" />
			</li>

		</form>

	<?php

} else {

	echo "Something went wrong, no current data set.";

}

?>