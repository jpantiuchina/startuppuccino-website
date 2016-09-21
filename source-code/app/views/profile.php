<div class="p_wrapper">

	<section class="p_infobox">
		<div class="head">
			<div class="p_info">
				<h3 class="p_name"><?php echo trim($user["firstname"]) . " " . trim($user["lastname"]); ?></h3>
				<p class="p_role c_<?php echo trim($user['role']);?>"><?php echo trim($user["role"]); ?></p>
				<p class="p_background"><?php echo trim($user["background"]); ?></p>	
				<p class="p_email">
					<a href="mailto:<?php echo trim($user["email"]); ?>">
						<span style="background-image:url('../app/assets/pics/default/mail.svg')"></span>
						<?php echo trim($user["email"]); ?>
					</a>
				</p>
			</div>
			<div class="p_picturebox">
				<div class="p_picture" style="background-image:url('../app/assets/pics/people/<?php echo $user['avatar']; ?>')"></div>
			</div>
		</div>
		<div class="foot">
			<div class="p_skills">
				<?php 
					$skills = explode(",", trim($user["skills"]));
					foreach ($skills as $skill) {
						?>
							<span><?php echo trim($skill); ?></span>
						<?php
					}
				?>
			</div>
		</div>
	</section>

	<section class="p_about">	
		<pre><?php echo trim($user["about"]); ?></pre>	
	</section>

	<section class="p_socials">
		
		<?php 

			// Socials array example:
			// ["facebook"=>["https://facebook.com/user/helloworld","primary"],"twitter"=>["https://twitter.com/user/helloworld","secondary"]]
			$socials = !empty($user["socials"]) ? json_decode(trim($user["socials"]),true) : array();
			foreach ($socials as $social_label => $social_data ) {
				// Fix url format
				if($social_label == "skype"){
					$social_data[0] = "skype:".$social_data[0];
				} else if($social_label == "whatsapp"){
					$social_data[0] = "whatsapp://".$social_data[0];
				} else if($social_label == "telegram"){
					// ...
				} else if(substr($social_label, 0, 7) == 'http://' || substr($social_label, 0, 8) == 'https://'){
					$social_data[0] = "//".$social_data[0];
				}
				
				?>
					<a class="profile_role <?php echo $social_data[1];?>" target="_blank" href="<?php echo $social_data[0];?>"><img src="../app/assets/pics/icons/<?php echo $social_label; ?>.svg" width="40" /></a>
				<?php
			}

		?>
	</section>
    					
    <?php

    	/*
		// Check if we are looking at our profile
	    if($people_func->isMyProfile()) {
	    	echo "<div class='button button--big'><a href='../account/'>Edit Profile</a></div>";
	    }
		*/

	?>

</div> <!-- end profile wrapper -->