
<div class="idea">

	<div class="picture_box">
		<div style="background-image:url('../app/assets/pics/default/new_picture.svg');background-size: 50%;"></div>
	</div>

	<form class="info_box" id="idea_form">

		<input id="idea_form_title" type="text" placeholder="Title..." name="title" required/>
		
		<input id="idea_form_avatar" type="hidden" name="avatar"/>

		<textarea id="idea_form_description" maxlength="140" placeholder="Description ( max 140c. ) ..." name="description" required/></textarea>
		
		<input id="idea_form_background_pref" type="text" placeholder="Looking for ..." name="background_pref" />

		<div class="info_box_footer">
			<input type="submit" class="c_green" value="Publish" />
			<input type="button" class="c_red" value="Cancel" onclick="SpIdea.cancelPublish()"/>
		</div>

	</form>

</div>

<div class="picture_form_wrapper">
	<form action="upload_controller.php" method="post" enctype="multipart/form-data" id="idea_form_picture_upload" target="notification_box">
	    
	    <li>
	        <label for="file_input">
	        	<div style="background-image:url('../app/assets/pics/default/add_picture.svg')" id="target_picture"></div>
	        </label>
	        <input type="file" accept="image/*" name="picture" id="file_input">
		</li>

		<input id="idea_picture_title" type="hidden" name="title" required/>

	    <li>
	    	<input type="submit" value="Upload" name="picture_submit">
	    </li>
	
	</form>
</div>

<!-- Need for async uploads, and used as upload notification box -->
<iframe id="notification_box" name="notification_box" style="display:none" src=""></iframe>

<script src="../app/assets/js/upload.js"></script>