
<?php if($account){ ?>
	
	<div class="settings__toprofile">
		<span><a href="../people/?user_id=<?php echo $_SESSION['id']; ?>">Watch your public profile</a></span>
	</div>

	<div class="settings__menu">
		<span><a href="#personal_info" onclick="Sp.helpers.scrollTo('personal_info', 200)">Personal Info</a></span>
		<span><a href="#password_settings" onclick="Sp.helpers.scrollTo('password_settings', 200)">Password</a></span>
		<span><a href="#picture_settings" onclick="Sp.helpers.scrollTo('picture_settings', 200)">Profile Picture</a></span>
		<span><a href="#social_links" onclick="Sp.helpers.scrollTo('social_links', 200)">Social Links</a></span>
	</div>

	<?php if( !empty($general_alert) ){ ?>
		<div class="message_alert_container">
			<h4><?php echo $general_alert; ?></h4>
		</div>
	<?php } ?>

	<form action="" method="post" class="form_custom" id="personal_info">

		<li class="form_box_item form_box_item--full">
			<h4>Personal Information</h4>
		</li>

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
			<label>
			<?php if ( $_SESSION['role'] === "student" ) { ?>
				Faculty
			<?php } else { ?>
				Company
			<?php } ?>
			</label>
			<input class="form_pretty_general_input" type="text" name="background" value="<?php echo trim($account['background']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Skills</label>
			<input class="form_pretty_general_input" type="text" name="skills" placeholder="e.g. IT, design, law, economics, management" value="<?php echo trim($account['skills']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Role</label>
			<input class="form_pretty_general_input" type="text" placeholder="<?php echo trim($account['role']);?>" disabled=""/>
		</li>

		<li class="form_box_item form_box_item--full">
			<label>About me <span style="color:#999">(optional)</span></label>
			<textarea class="form_pretty_general_input" name="about" placeholder="More info about me, about my startup idea, etc."><?php echo trim($account['about']);?></textarea>
		</li>

		<br>

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_account_info" value="Save" />
		</li>						
	</form>





	<form action="" method="post" class="form_custom" onsubmit="return checkForm();" id="password_settings">

		<li class="form_box_item form_box_item--full">
			<h4>Change Password</h4>
		</li>
		
		<li class="form_box_item">
			<label>Old Password</label>
			<input class="form_pretty_general_input" type="password" name="old_password" id="password_input_1" required/>
		</li>

		<li class="form_box_item">
			<label>New Password</label>
			<input class="form_pretty_general_input" type="password" name="new_password" id="password_input_2" required/>
		</li>

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_password" value="Save" />
		</li>

	</form>





	<form action="upload_controller.php" method="post" class="form_custom" enctype="multipart/form-data" onsubmit="return upload_form_submit();" target="notification_box" id="picture_settings">
        
		<li class="form_box_item form_box_item--full">
        	<h4>Profile Picture</h4>
        </li>
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





    <form class="form_custom" id="social_links">

    	<script>
    		<?php 
    			$account_socials = trim($account["socials"]);
    			if($account_socials == ""){
    				$account_socials = "{}";
    			}
    		?>    		
    		var CURRENT_SOCIALS = <?php echo $account_socials;?>;
    	</script>
	
		<li class="form_box_item form_box_item--full">
			<h4>Social links</h4>
		</li>
	
		<?php 

		// Socials array example:
		// ["facebook"=>["https://facebook.com/user/helloworld","primary"],"twitter"=>["https://twitter.com/user/helloworld","secondary"]]
		$socials = !empty($account["socials"]) ? json_decode(trim($account["socials"]),true) : array();
		$default_socials = ['facebook','twitter','linkedin','instagram','skype','whatsapp','youtube','website'];
		//$default_socials = ['facebook','twitter','linkedin','behance','googleplus','instagram','skype','telegram','vimeo','whatsapp','youtube','website'];

		foreach ($default_socials as $social) {
			
			?>

			<li class="form_box_item social" id="<?php echo $social; ?>">
				<label for="<?php echo $social; ?>_link"><img style="width:50px" src="../app/assets/pics/icons/<?php echo $social; ?>.svg" alt="<?php echo $social; ?>" /></label>
				<input type="link" class="form_pretty_general_input" id="<?php echo $social; ?>_link" value="<?php if(isset($socials[$social]))echo $socials[$social][0];?>" placeholder="Url" />
				<label style="display: none"><input type="checkbox" id="<?php echo $social; ?>_priority" <?php if(isset($socials[$social]) && $socials[$social][1]=="primary"){echo "checked='checked'";}?> />Favorite</label>
			</li>

		<?php } ?>
	
		<br>

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="button" onclick="saveSocialInputs()" value="Save" />
		</li>

	</form>





	<script type="text/javascript" src="../app/assets/js/account.js"></script>
	<script type="text/javascript" src="../app/assets/js/upload.js"></script>

<?php } else { ?>

	<h2>Something went wrong, no account selected.</h2>

<?php } ?>
