<?php

	if($account){
	
?>
	
	<style>.form_box_item{vertical-align: top;}</style>

	<form action="" method="post" class="form_custom" >

		<li class="form_box_item">
			<label>Firstname</label>
			<input class="form_pretty_general_input" type="text" name="firstname" value="<?php echo trim($account['firstName']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Lastname</label>
			<input class="form_pretty_general_input" type="text" name="lastname" value="<?php echo trim($account['lastName']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Email</label>
			<input class="form_pretty_general_input" type="email" name="email" value="<?php echo trim($account['email']); ?>" required/>
		</li>

		<li class="form_box_item">
			<label>Faculty(Student)/Company(Mentor)</label>
			<input class="form_pretty_general_input" type="text" name="background" value="<?php echo trim($account['background']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Skills</label>
			<input class="form_pretty_general_input" type="text" name="skills" placeholder="e.g. IT, design, law, economics, management" value="<?php echo trim($account['skills']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>About me (optional)</label>
			<textarea class="form_pretty_general_input" name="about" placeholder="More info about me, about my startup idea, etc."><?php echo trim($account['about']);?></textarea>
		</li>


		<!-- Temporary -->
		<input type="hidden" value="<?php echo $account['role'];?>" name="role">

		<!--

		<li class="form_box_item">
			<label>Role</label>
			<?php

			// If the user is an educator (a super user)
			// we do not need to show the possibility to change role.

			if ($account['role'] == "educator") {

				?>

					<label>
						<input type="radio" name="role" value="educator" checked="checked" required/>Educator (I am superman)
					</label>

				<?php

			} else {

				?>

					<label>
						<input type="radio" name="role" value="student" <?php if ($account['role'] == "student") print "checked=\"checked\"";?> required/>Student (I'm here to learn)
					</label>
					<label>
						<input type="radio" name="role" value="mentor" <?php if ($account['role'] == "mentor") print "checked=\"checked\"";?> required/>Mentor (I'm here to help)
					</label>
		
				<?php

			}

			?>
		</li>

			-->

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_account_info" value="SAVE" />
		</li>						
	</form>

	<style>hr{border: 0;height: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);border-bottom: 1px solid rgba(255, 255, 255, 0.3);}</style>
	<hr>

	<form action="" method="post" class="form_custom" onsubmit="return checkForm();">

		<h4>Change Password</h4>
		
		<li class="form_box_item">
			<label>Old Password</label>
			<input class="form_pretty_general_input" type="password" name="old_password" id="password_input_1" required/>
		</li>

		<li class="form_box_item">
			<label>New Password</label>
			<input class="form_pretty_general_input" type="password" name="new_password" id="password_input_2" required/>
		</li>

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_password" value="SAVE" />
		</li>

	</form>

	<hr>

	<form action="upload_controller.php" method="post" class="form_custom" enctype="multipart/form-data" onsubmit="return upload_form_submit();" target="notification_box">
        <h4>Profile Picture</h4>
        <li class="form_box_item">
	        <label for="file_input" style="cursor:pointer"><img src="../app/assets/pics/people/<?php echo trim($account['avatar']);?>" id="target_picture" style="max-height:200px;max-width:200px" alt="Upload Your Profile Picture" /></label>
	        <input class="form_pretty_button_input" style="cursor:pointer"  type="file" accept="image/*" name="picture" id="file_input">
    	</li>
    	<br>
        <li class="form_box_item">
        	<input class="form_pretty_button_input" type="submit" value="Upload" name="picture_submit">
        </li>
    </form>
    <!-- Need for async uploads, and used as upload notification box -->
    <iframe id="notification_box" name="notification_box" style="display:none" src=""></iframe>


    <hr>

    <div class="form_custom">
	
		<h4>Social links</h4>
	
		<?php 

		// Socials array example:
		// ["facebook"=>["https://facebook.com/user/helloworld","primary"],"twitter"=>["https://twitter.com/user/helloworld","secondary"]]
		$socials = !empty($account["socials"]) ? json_decode(trim($account["socials"]),true) : array();
		$default_socials = ['facebook','twitter','linkedin','behance','googleplus','instagram','skype','telegram','vimeo','whatsapp','youtube','website'];

		foreach ($default_socials as $social) {
			
			?>

			<li class="social form_box_item" id="<?php echo $social; ?>" style="border:1px solid #f2f2f2;margin:5px 0px">
				<label for="<?php echo $social; ?>_link"><img style="width:50px" src="../app/assets/pics/icons/<?php echo $social; ?>.svg" alt="<?php echo $social; ?>" /></label>
				<input type="link" class="form_pretty_general_input" id="<?php echo $social; ?>_link" value="<?php if(isset($socials[$social]))echo $socials[$social][0];?>" placeholder="Url" />
				<label><input type="checkbox" id="<?php echo $social; ?>_priority" <?php if(isset($socials[$social]) && $socials[$social][1]=="primary"){echo "checked='checked'";}?> />Favorite</label>
			</li>

			<?php

		}

		?>
	
		<br>

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="button" onclick="saveSocialInputs()" value="SAVE" />
		</li>

	</div>


	<script type="text/javascript" src="../app/assets/js/account.js"></script>
	<script type="text/javascript" src="../app/assets/js/upload.js"></script>

<?php

	} else {

		"No account selected.";

	}

?>