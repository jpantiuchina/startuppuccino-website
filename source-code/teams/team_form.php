<?php 

// Check if current data are set
if(count($team_data)>1){

	?>

		<form class="form_custom form_custom--slim" action="" method="post">

			<li class="form_box_item">
				<label for="name">Team name</label>
				<input class="form_pretty_general_input" type="text" name="name" value="<?php echo $team_data['name'];?>" required/>
			</li>

			<input type="hidden" name="team_id" value="<?php echo $team_data['id'];?>" />
			
			<li class="form_box_item">
				<input class="form_pretty_button_input" type="submit" name="submit_team" value="SAVE" />
			</li>

		</form>

		<form class="form_custom form_custom--slim" action="" method="post" onsubmit="return confirm('Are you sure you want to leave this team?');">
			
			<li class="form_box_item">
				<input class="form_pretty_button_input" type="submit" name="submit_quit_team" value="LEAVE TEAM" />
			</li>

		</form>

	<?php

} else {

	echo "Something went wrong, no current data set.";

}

?>