<?php

	
	// Only if is a mentor we load the sessions availability
   	if($_SESSION['role'] !== "mentor"){
   		exit("You are not a mentor");
   	}

   	// TODO: all this should be in the controller

	require_once '../app/models/CourseSessions_Functions.php';
	$cs_func = new CourseSessions_Functions();
	$lectures_availability = $cs_func->getMentorSessionAvailability($_SESSION['id']);


	// Temporary solution to check if the session id is in the array of lecture selected by the user
	function i_am_attending($s_id,$lectures){
		foreach ($lectures as $key => $value) {
			if ($s_id == $key) return true;
		}
		return false;
	}


?>

<section class="column_right" id="column_right" data-sidebar="0">

	<div class="sidebar_container">

		<div class="overlay_mobile__button" onclick="SpHome.layout.toggleSidebar()"></div>

		<div class="head">
			<span>Will you come to mentor the session in the afternoon?</span>
		</div>

		<div class="main">

			<?php 
			
				$l = count($sessions_set);
				for ($i=0; $i < $l; $i++) { 
			
					$session = $sessions_set[$i];
					$pitch_class = "";
					$pitch_ = 0;
					$pitch_title = "";
			
					$session_date = date("Y-m-d", strtotime($session['date']));

					if ($session_date < date("Y-m-d")) {
						continue;
					}

					if ( i_am_attending($session['id'], $lectures_availability) ){
						$data_action = "remove";
						$pitch_title = $lectures_availability[$session['id']][1];
						$pitch_ = intval($lectures_availability[$session['id']][0]);
						switch ($pitch_) {
							case 0:
								$pitch_class = "";
								break;
							case 1:
								$pitch_class = "checked";
								break;
							case 2:
								$pitch_class = "denied";
								break;
							case 3:
								$pitch_class = "approved";
								break;	
						}
					} else {
						$data_action = "add";
					}
				?>

				<div class="list_el">
			 		<div class="list_el__left">
			 			<a href="#session<?php echo $session['id']; ?>" class="sessions_sidebar_link">
					 		<p><?php echo $session['title']; ?></p>
					 		<?php if( $pitch_title !== "" ){ ?>
					 		<p>Title: <?php echo $pitch_title; ?></p>
					 		<?php } ?>
					 		<p><?php echo date("d/m/Y", strtotime($session['date'])); ?></p>
					 	</a>
					</div>
					<div class="list_el__right">
						<div class="button_availability action_<?php echo $data_action; ?>"
							 data-session="<?php echo $session['id']; ?>"
							 data-action="<?php echo $data_action; ?>">
							<span>YES</span><!--
							--><span>NO</span>
						</div>
						<?php 
							/*
							<div class="button_pitch">
								<label class="<?php echo $pitch_class; ?>">
									<div class="button_toggle_pitch"
										 data-session="<?php echo $session['id']; ?>"
										 data-pitch="<?php echo $pitch_; ?>"></div>
									<span>PITCH</span><!--
									--><input type="checkbox" 
											  style="display: none"
											  <?php echo ($pitch_class === "checked") ? 'checked=""' : ''; ?>" />
								</label>
							</div>
							*/
						?>
						<div class="tiny_loader" style="display:none">
							<div></div><div></div>
						</div>
					</div>
				</div>

			<?php } // End of for loop ?>

		</div>

	</div>

</section>