<form class="form_custom form_custom--slim" action="" method="post">

	<li class="form_box_item">
		<label for="name">Team name</label>
		<input class="form_pretty_general_input" type="text" name="name" <?php if(isset($_POST['name'])) print('value="'.$_POST['name'].'"'); ?> required/>
	</li>
	
	<li class="form_box_item">
		<label for="vision">Member</label>
		<!-- -->
	</li>
	
	<li class="form_box_item">
		<!-- include the project form -->
		
	</li>

	<li class="form_box_item">
		<input class="form_pretty_button_input" type="submit" name="submit_team" value="Done" />
	</li>

</form>