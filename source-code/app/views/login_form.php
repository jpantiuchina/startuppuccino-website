
<!--
<script type="text/javascript" src="//platform.linkedin.com/in.js">
    api_key: YOUR_API_KEY_HERE
    authorize: true
    onLoad: onLinkedInLoad
</script>

<script type="in/Login"></script>

-->

<?php $form_action = isset($form_action) ? $form_action : ""; ?>

<form class="form_custom form_login" action="<?php echo $form_action ?>" method="post">

	<?php if(!$loginOk){ ?>

		<li class="form_box_item form_box_item--full">
			<p>Account not found, check the inputs data</p>
		</li>

	<?php } ?>

	<li class="form_box_item">
		<label for="email">Email</label>
		<input class="form_pretty_general_input" type="email" name="email" placeholder="Hello@startuppuccino.com" <?php if(isset($_POST['email'])) print('value="'.$_POST['email'].'"'); ?> required/>
	</li>
	
	<li class="form_box_item">
		<label for="password">Password</label>
		<input class="form_pretty_general_input" type="password" name="password" <?php if(isset($_POST['password'])) print('value="'.$_POST['password'].'"'); ?> required/>
	</li>

	<li class="form_box_item">
		<label class="form_pretty_general_input">
			<input type="checkbox" name="permalogin" value="y" <?php if(isset($_POST['permalogin'])) echo 'checked="checked"'; ?> />stay logged in
		</label>
	</li>
	
	<li class="form_box_item">

			<input class="form_pretty_button_input" type="submit" name="login" value="Login" />
		<p>
			<a class="form_input--forgot_password form_pretty_button_link" href="../resetpassword/" target="_blank">Forgot Password</a>
		</p>
	</li>
	
	<li class="form_box_item form_box_item--full">
        <p>New user? <a class="form_pretty_button_link" href="../register/">Register</a></p>
    </li>

</form>