<form action="" method="post" class="form_custom" onsubmit="return checkForm();">

	<?php if($error_message != ""){ ?>

		<li class="form_box_item form_box_item--full">
			<p><?php print $error_message; ?></p>
		</li>

	<?php } ?>

	<li class="form_box_item">
		<label>Email</label>
		<input class="form_pretty_general_input" type="email" name="email" placeholder="hello@startuppucino.com" <?php if(isset($_POST['email'])) print('value="'.$_POST['email'].'"'); ?> required/>
	</li>

	<li class="form_box_item">
		<label>Password</label>
		<input class="form_pretty_general_input" type="password" id="password_input_1" name="password" <?php if(isset($_POST['password'])) print('value="'.$_POST['password'].'"'); ?> required/>
	</li>

	<li class="form_box_item">
		<label>Repeat Password</label>
		<input class="form_pretty_general_input"  id="password_input_2" type="password" name="password1" required/>
	</li>

	<li class="form_box_item">
		<label>Firstname</label>
		<input class="form_pretty_general_input" type="text" name="firstname" <?php if(isset($_POST['firstname'])) print('value="'.$_POST['firstname'].'"'); ?>required/>
	</li>

	<li class="form_box_item">
		<label>Lastname</label>
		<input class="form_pretty_general_input" type="text" name="lastname" <?php if(isset($_POST['lastname'])) print('value="'.$_POST['lastname'].'"'); ?> required/>
	</li>

	<li class="form_box_item">
		<label>Background</label>
		<input class="form_pretty_general_input" type="text" name="background" placeholder="e.g. IT, design, law, economics, management" <?php if(isset($_POST['background'])) print('value="'.$_POST['background'].'"'); ?> required/>
	</li>

	<li class="form_box_item">
		<label>About me (optional)</label>
		<textarea class="form_pretty_general_input" rows="3" name="about" placeholder="More info about me, about my startup idea, etc."><?php if(isset($_POST['about'])) print($_POST['about']); ?></textarea>
	</li>

	<li class="form_box_item">
		<label>Role</label>
		<label><input type="radio" name="role" value="user" <?php if($_POST['role']=="user") print 'checked="checked"' ?> required/>User (I'm here to learn)</label>
		<label><input type="radio" name="role" value="mentor"  <?php if($_POST['role']=="mentor") print 'checked="checked"' ?> required/>Mentor (I'm here to help)</label>
	</li>

	<?php 
		// I suggest not to let user upload the picture here 
		// but only once already signed up from their account page.
	?>

	<li class="form_box_item">
		<input class="form_pretty_button_input" type="submit" value="Register" name="submit">
	</li>

	<li class="form_box_item form_box_item--full">
        <p>Do you already have an Account? <a class="form_pretty_button_link" href="../login/">Login</a></p>
    </li>

</form>

<script type="text/javascript">
function checkForm(){
	// Add here some client checks to prevent bad ux
	// If you want to block -> return false;
	// If you want to proceed with post submitting -> return true;

	// Check if password doublecheck match
	if(document.getElementById('password_input_1').value == document.getElementById('password_input_2').value)
		return true;
	else
		alert("Passwords do not match!");
		return false;

}
</script>