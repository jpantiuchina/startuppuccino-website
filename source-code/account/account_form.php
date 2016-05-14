<?php

	if($account){
	
?>

	<form action="" method="post" class="form_custom" >

		<li class="form_box_item">
			<label>Email</label>
			<input class="form_pretty_general_input" type="email" name="email" value="<?php print $account['email']; ?>" required/>
		</li>

		<li class="form_box_item">
			<label>Firstname</label>
			<input class="form_pretty_general_input" type="text" name="firstname" value="<?php print $account['firstname'];?>" required/>
		</li>

		<li class="form_box_item">
			<label>Lastname</label>
			<input class="form_pretty_general_input" type="text" name="lastname" value="<?php print $account['lastname'];?>" required/>
		</li>

		<li class="form_box_item">
			<label>Background</label>
			<input class="form_pretty_general_input" type="text" name="background" placeholder="e.g. IT, design, law, economics, management" value="<?php print $account['background'];?>" required/>
		</li>

		<li class="form_box_item">
			<label>About me (optional)</label>
			<textarea class="form_pretty_general_input" name="about" placeholder="More info about me, about my startup idea, etc."><?php print $account['about'];?></textarea>
		</li>

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

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_account_info" value="SAVE" />
		</li>						
	</form>

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


	<script type="text/javascript">
		function checkForm(){
			// Add here some client checks to prevent bad ux
			// If you want to block -> return false;
			// If you want to proceed with post submitting -> return true;

			// Check if old and new password match
			if(document.getElementById('password_input_1').value != document.getElementById('password_input_2').value)
				return true;
			else
				alert("Old and new password are the same!");
				// reset new password input
				document.getElementById('password_input_2').value = "";
				return false;
		}
	</script>

	<!-- 
		TODO -> Add form to upload profile picture
		hint: use the iframe and with a javascript callback
			  in order to make the upload async
	-->

<?php

	} else {

		"No account selected.";

	}

?>