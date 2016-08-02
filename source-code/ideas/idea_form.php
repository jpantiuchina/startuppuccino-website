<form action="upload_controller.php" method="post" class="form_custom" enctype="multipart/form-data" onsubmit="return uploadIdeaPicture();" target="notification_box">
    <h4>Picture</h4>
    <li class="form_box_item">
        <label for="file_input" style="cursor:pointer"><img src="../app/assets/pics/default/picture_upload.svg" id="target_picture" style="max-height:200px;max-width:200px" alt="Upload Picture" /></label>
        <input class="form_pretty_button_input" style="cursor:pointer"  type="file" accept="image/*" name="picture" id="file_input">
	</li>
	<input id="idea_picture_title" type="hidden" name="title" required/>
	<br>
    <li class="form_box_item">
    	<input class="form_pretty_button_input" type="submit" value="Upload" name="picture_submit">
    </li>
</form>
<!-- Need for async uploads, and used as upload notification box -->
<iframe id="notification_box" name="notification_box" style="display:none" src=""></iframe>


<form class="form_custom form_custom--slim" action="#" onsubmit="return publishIdea();">

	<li class="form_box_item">
		<label for="title">Idea Title</label>
		<input class="form_pretty_general_input" id="idea_form_title" type="text" name="title" required/>
	</li>

	<input id="idea_form_avatar" type="hidden" name="avatar"/>

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

<script src="../app/assets/js/upload.js"></script>