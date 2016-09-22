<?php

	// Temporary solution to check if the session id is in the array of lecture selected by the user
	function i_am_attending($s_id){
		foreach ($_SESSION['lectures_availability'] as $key => $value) {
			if ($s_id == $key) return true;
		}
		return false;
	}

?>

<section class="column_right">

	<div class="sidebar_container">

		<div class="head">
			<span>Lecture's attendance</span>
		</div>

		<div class="main">

			<?php 
			
				$l = count($sessions_set);
				for ($i=0; $i < $l; $i++) { 
			
					$session = $sessions_set[$i];
					$checkbox = ""; 
					$pitch_ = 1;
			
					if (i_am_attending($session['id'])){
						$data_action = "remove";
						$pitch_ = 1 - intval($_SESSION['lectures_availability'][$session['id']]); // 0 or 1
						if($pitch_ === 0){
							$checkbox = "checked";
						}
					} else {
						$data_action = "add";
					}
				?>

				<div class="list_el">
			 		<div class="list_el__left">
			 			<a href="#session<?php echo $session['id']; ?>">
					 		<p><?php echo $session['title']; ?></p>
					 		<p><?php echo $session['date']; ?></p>
					 	</a>
					</div>
					<div class="list_el__right">
						<div class="button_availability action_<?php echo $data_action; ?>"
							 data-session="<?php echo $session['id']; ?>"
							 data-action="<?php echo $data_action; ?>">
							<span 
								<?php if($data_action === "add") { ?>
								onclick="SpHome.mentors.setAvailability(<?php echo $session['id']; ?>,this)"
								<?php } ?>>YES</span><!--
							--><span 
								<?php if($data_action === "remove") { ?>
								onclick="SpHome.mentors.setAvailability(<?php echo $session['id']; ?>,this)"
								<?php } ?>>NO</span>
						</div>
						<div class="button_pitch">
							<label class="<?php echo $checkbox; ?>">
								<div class="button_toggle_pitch"
									 data-session="<?php echo $session['id']; ?>"
									 data-pitch="<?php echo $pitch_; ?>"></div>
								<span>PITCH</span><!--
								--><input type="checkbox" 
										  <?php echo ($checkbox === "checked") ? 'checked=""' : ''; ?>" />
							</label>
						</div>
						<div class="tiny_loader" style="display:none">
							<div></div><div></div>
						</div>
					</div>
				</div>

			<?php } // End of for loop ?>

		</div>

	</div>

</section>