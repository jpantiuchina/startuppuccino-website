<?php // Course session form to edit a session -- only for educators ?>
<div id="edit_course_session">
	
	<div class="center_column">
		<div class="center_aligner">
			
			<div class="background_close" onclick="hideEditSession()"></div>

			<form class="course_session_form" onsubmit="return editSession();">
				<div class="_closer" onclick="hideEditSession()">X</div>
				<input type="hidden" id="coursesession_id" value="" required />
				<label>Title</label>
				<input type="text" id="coursesession_title" value="" required />
				<label>Description</label>
				<textarea id="coursesession_description" required></textarea>
				<input type="submit" name="submit" value="Save">
			</form>
		</div>
	</div>

</div>

<div id="edit_course_session_resources">
	
	<div class="center_column">
		<div class="center_aligner">
			
			<div class="background_close" onclick="hideEditSessionResources()"></div>

			<form class="course_session_form" onsubmit="return editSessionResources();">
				<div class="_closer" onclick="hideEditSessionResources()">X</div>
				<input type="hidden" id="coursesession_id" value="" required />
				<!-- -->
				<input type="submit" name="submit" value="Save">
			</form>
		</div>
	</div>

</div>