<form class="form_custom form_custom--slim" action="" method="post">

	<li class="form_box_item">
		<label for="title">Project Title</label>
		<input class="form_pretty_general_input" type="text" name="title" <?php if(isset($_POST['title'])) print('value="'.$_POST['title'].'"'); ?> required/>
	</li>
	
	<li class="form_box_item">
		<label for="vision">Vision</label>
		<textarea class="form_pretty_general_input" name="vision" />
			<?php if(isset($_POST['vision'])) print $_POST['vision']; ?>
		</textarea>
	</li>
	
	<li class="form_box_item">
		<label for="description">Project description</label>
		<textarea class="form_pretty_general_input" name="description" />
			<?php if(isset($_POST['description'])) print $_POST['description']; ?>
		</textarea>
	</li>

	<li class="form_box_item">
		<input class="form_pretty_button_input" type="submit" name="submit_project" value="Publish" />
	</li>

</form>