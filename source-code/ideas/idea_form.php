<form class="form_custom form_custom--slim" action="#" onsubmit="return publishIdea();">

	<li class="form_box_item">
		<label for="title">Idea Title</label>
		<input class="form_pretty_general_input" id="idea_form_title" type="text" name="title" required/>
	</li>

	<?php 
	/*
	<li class="form_box_item">
		<label for="team_size">Team Size</label>
		<input class="form_pretty_general_input" id="idea_form_team_size" type="number" min="2" step="1" name="team_size" required/>
	</li>
	*/
	?>

	<li class="form_box_item">
		<label for="description">Description</label>
		<textarea class="form_pretty_general_input" id="idea_form_description" maxlength="140" name="description" required/></textarea>
	</li>
	
	<li class="form_box_item">
		<label for="background_pref">Preferred Memebers Background</label>
		<input class="form_pretty_general_input" type="text" id="idea_form_background_pref" name="background_pref" />
	</li>

	<li class="form_box_item">
		<input class="form_pretty_button_input" type="submit" value="Publish" />
	</li>

</form>